<?php

namespace App\Http\Controllers;

use App\Http\Services\PaypalService;
use App\Models\Account;
use App\Models\Beat;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    /**
     * @var PaypalService
     */
    protected $paypalService;

    /**
     * PaypalController constructor.
     * @param PaypalService $paypalService
     */
    public function __construct(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }


    public function createOnboardingLink()
    {
        $user = \Auth::user();

        return response()->json([
            'link' => $this->paypalService->getSignUpLink($user->id),
        ]);
    }

    public function completeOnboarding(Request $request)
    {
        $user = \Auth::user();
        $data = $request->validate([
            'consentStatus' => ['required', 'string', 'in:true,false'],
            'isEmailConfirmed' =>  ['required', 'string', 'in:true,false'],
            'merchantId' => ['required', 'string', 'min:3'],
            'merchantIdInPayPal' => ['required', 'string', 'min: 3'],
            'permissionsGranted' =>  ['required', 'string', 'in:true,false'],
        ]);

        if ((string)$user->id !== $data['merchantId']) {
            return response()->json([
                'errors' => [
                    'merchantId' => 'This id does not match your user',
                ]
            ], 403);
        }

        $status = $this->paypalService->getOnboardingStatus($data['merchantIdInPayPal']);
        if ($status['tracking_id'] !== (string)$user->id) {
            return response()->json([
                'errors' => [
                    'tracking_id' => 'This id does not match your user',
                ]
            ], 403);
        }

        if ($status['payments_receivable'] ===  true && $status['primary_email_confirmed'] === true && count($status['oauth_integrations']) > 0) {
            $account  = Account::create([
                'provider_id' => $data['merchantIdInPayPal'],
                'provider_name' => 'PAYPAL',
                'user_id' => $user->id,
                'email' => $status['primary_email'],
            ]);

            return response()->json([], 200);
        } else {
            return response()->json([
                'errors' => [
                    'Onboarding' => 'Not all permissions got granted',
                ]
            ], 400);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder()
    {
        $user = \Auth::user();
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => Cart::STATUS_OPEN,
        ],
            [
                'user_id' => $user->id
            ]
        );

        if ($cart->beats->count() < 1) {
            return response()->json([
                'errors' => [
                    'No beats in your cart',
                ]
            ], 400);
        }

        $cart->update([
            'status' => Cart::STATUS_LOCKED
        ]);

        foreach ($cart->beats as $beat) {
            if ($beat->is_exclusive) {
                if ($beat->status !== Beat::STATUSES['AVAILABLE']) {
                    return response()->json([
                        'errors' => [
                            'Beat ' . $beat->name . ' is not available'
                        ]
                    ], 400);
                }
                $beat->update([
                    'status' => Beat::STATUSES['PURCHASED']
                ]);
            }
        }

        $id = $this->paypalService->createOrder($cart, $user);
        return response()->json([
            'id' => $id,
        ]);
    }

    public function captureOrder(Request $request, string $orderId)
    {
        $order = $this->paypalService->captureOrder($orderId);
        $this->paypalService->sendMoneyToSellers($order);

        return response()->json([
            'ok' => true
        ]);
    }
}
