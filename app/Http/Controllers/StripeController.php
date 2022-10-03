<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripeController extends Controller
{
    /**
     * @var StripeClient
     */
    protected $stripeClient;

    /**
     * StripeController constructor.
     * @param StripeClient $stripeClient
     */
    public function __construct(StripeClient $stripeClient)
    {
        $this->stripeClient = $stripeClient;
    }


    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');

        $event = null;

        // Verify webhook signature and extract the event.
        // See https://stripe.com/docs/webhooks/signatures for more information.
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, env('STRIPE_WEBHOOK_SECRET')
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload.
            return response()->json([], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid Signature.
            return response()->json([], 400);
        }

//        if ($event->type == 'payment_intent.succeeded') {
//            $paymentIntent = $event->data->object;
//            $purchase = Purchase::where('provider_id', '=', $paymentIntent->id)->first();
//            \Log::info('Purchase retrieved', ['purchase' => $purchase, ]);
//            $cart = Cart::find($purchase->cart_id);
//            \Log::info('cart retrieved', ['cart' => $cart]);
//            $purchase->update([
//                'receipt_url' => $paymentIntent->charges->data[0]->receipt_url
//            ]);
//            $totalPerUser = [];
//            foreach ($cart->beats as $beat) {
//                if (isset($totalPerUser[$beat->user_id])) {
//                    $totalPerUser[$beat->user_id] += $beat->pivot->price;
//                } else {
//                    $totalPerUser[$beat->user_id] = $beat->pivot->price;
//                }
//
//                $purchase->beats()->attach($beat->id,[
//                    'price' => $beat->pivot->price
//                ]);
//            }
//
//            $cart->delete();
//
//            foreach ($totalPerUser as $userId => $value) {
//                $user = User::find($userId);
//                $fee =  (int)floor($value * 100 * 0.2);
//                \Log::info('To pay to user', ['fee' => $fee, 'amount' => $value - $fee]);
//
//                try {
//                    $this->stripeClient->transfers->create([
//                        'amount' => ($value * 100) - $fee,
//                        'currency' => 'gbp',
//                        'destination' => $user->stripe_connect_id ?? 'acct_1Iw5kLQrFlhSWXcX',
//                        'transfer_group' => $purchase->id,
//                        'description' => 'Beats sold on thathrowdown.com'
//                    ]);
//                } catch (\Exception $e) {
//                    \Log::error($e->getMessage(), ['transfer' => $userId]);
//                }
//            }
//
//            \Log::info('Payment Success', ['data' => $paymentIntent ]);
//        }


        if ($event->type == 'charge.succeeded') {
            $charge = $event->data->object;
            $purchase = Purchase::where('provider_id', '=', $charge->payment_intent)->first();
            $cart = Cart::find($purchase->cart_id);
            $purchase->update([
                'receipt_url' => $charge->receipt_url
            ]);
            $totalPerUser = [];
            foreach ($cart->beats as $beat) {
                if (isset($totalPerUser[$beat->user_id])) {
                    $totalPerUser[$beat->user_id] += $beat->pivot->price;
                } else {
                    $totalPerUser[$beat->user_id] = $beat->pivot->price;
                }

                $purchase->beats()->attach($beat->id,[
                    'price' => $beat->pivot->price
                ]);
            }

            $cart->delete();

            foreach ($totalPerUser as $userId => $value) {
                $user = User::find($userId);
                $fee =  (int)floor($value * 100 * 0.2);

                try {
                    $this->stripeClient->transfers->create([
                        'amount' => ($value * 100) - $fee,
                        'currency' => 'gbp',
                        'destination' => $user->stripe_connect_id ?? 'acct_1Iw5kLQrFlhSWXcX',
                        'transfer_group' => $purchase->id,
                        'description' => 'Beats sold on thathrowdown.com'
                    ]);
                } catch (\Exception $e) {
                    \Log::error($e->getMessage(), ['transfer' => $userId]);
                }
            }

        }

        return response()->json([], 200);
    }
}

