<?php


namespace App\Http\Services;


use App\Models\Cart;
use App\Models\Purchase;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaypalService
{
    public function getSignUpLink(string $userId)
    {
        $token = $this->getAccessToken();
        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])->post(env('PAYPAL_API_URL') . '/v2/customer/partner-referrals', [
                'tracking_id' => $userId,
                'operations' => [
                    [
                        "operation" => "API_INTEGRATION",
                        "api_integration_preference" => [
                            "rest_api_integration" => [
                                "integration_method" => "PAYPAL",
                                "integration_type" => "THIRD_PARTY",
                                "third_party_details" => [
                                    "features" => [
                                        "PAYMENT",
                                        "REFUND",
                                        "DELAY_FUNDS_DISBURSEMENT",
                                        "PARTNER_FEE"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "products" => [
                    'EXPRESS_CHECKOUT'
                ],
                "legal_contents" => [
                    [
                        "type" => "SHARE_DATA_CONSENT",
                        "granted" => true
                    ]
                ],
                'partner_config_override' => [
                    'return_url' => env('SPA_URL') . '/onboarding_complete',
                    'action_renewal_url' => env('SPA_URL') . '/onboarding',
                ]
            ]);

        return $response['links'][1]['href'];
    }

    /**
     * @return string
     */
    private function getAccessToken(): string
    {
        $response = Http::withBasicAuth(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'))
            ->withHeaders([
                'Accept' => 'application/json',
                'Accept-Language' => 'en_GB',
            ])->asForm()
            ->post(env('PAYPAL_API_URL') . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        return $response['access_token'];
    }

    public function getOnboardingStatus(string $merchantId)
    {
        $token = $this->getAccessToken();
        return Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])->get(env('PAYPAL_API_URL') . '/v1/customer/partners/' . env('PAYPAL_MERCHANT_ID') . '/merchant-integrations/' . $merchantId);
    }

    public function createOrder(Cart $cart, User $user)
    {
        $total = 0;
        $purchase = new Purchase();
        $purchase->user_id = $user->id;
        $purchase->price = $total;
        $purchase->cart_id = $cart->id;
        $purchase->save();
        $purchaseUnits = [];

        foreach ($cart->beats as $beat) {
            $purchaseUnit = [
                'reference_id' => $purchase->id . '_' . $beat->id ,
                'amount' => [
                    'currency_code' => 'GBP',
                    'value' => $beat->pivot->price,
                ],
                'payee' => [
                    'email_address' => $beat->uploader->accounts()->where('provider_name', '=', 'PAYPAL')->first()->email ?? env('PAYPAL_DEFAULT_SENDEE_ACCOUNT'),
                ],
                'description' => Str::substr($beat->name, 0, 127),
                'payment_instruction' => [
                    'disbursement_mode' => 'DELAYED',
                    'platform_fees' => [
                        [
                            'amount' => [
                                'currency_code' => 'GBP',
                                'value' => round($beat->pivot->price * 0.2, 2, PHP_ROUND_HALF_DOWN),
                            ]
                        ]
                    ]
                ]
            ];

            $purchaseUnits[] = $purchaseUnit;

            $purchase->beats()->attach($beat->id, [
                'price' => $beat->pivot->price
            ]);
            $total += $beat->pivot->price;
        }

        $purchase->update([
            'price' => $total,
        ]);


        $token = $this->getAccessToken();
        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])->post(env('PAYPAL_API_URL') . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => $purchaseUnits
            ]);

        $purchase->update([
            'provider_id' => $response['id'],
            'provider' => 'PAYPAL',
        ]);

        return $response['id'];
    }

    public function captureOrder(string $orderId)
    {
        $token = $this->getAccessToken();
        $client = new Client();
        $response = $client
            ->request('POST', env('PAYPAL_API_URL') . '/v2/checkout/orders/' . $orderId . '/capture', [
               'headers' => [
                   'Content-Type' => 'application/json',
                   'Authorization' => 'Bearer ' . $token,
               ]
            ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function sendMoneyToSellers($order)
    {
        $purchaseUnits = $order['purchase_units'];
        $token = $this->getAccessToken();
        foreach ($purchaseUnits as $purchaseUnit) {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])->post(env('PAYPAL_API_URL') . '/v1/payments/referenced-payouts-items', [
                    'reference_id' => $purchaseUnit['payments']['captures'][0]['id'],
                    'reference_type' => 'TRANSACTION_ID',
                ]);
        }

        $purchase = Purchase::where('provider_id', '=', $order['id'])->first();
        if ($purchase) {
            $purchase->update([
                'confirmed_at' => now(),
            ]);
        }
    }
}
