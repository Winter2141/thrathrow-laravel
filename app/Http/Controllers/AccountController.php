<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class AccountController extends Controller
{
    /**
     * @var StripeClient
     */
    protected $stripeClient;

    /**
     * AccountController constructor.
     * @param StripeClient $stripeClient
     */
    public function __construct(StripeClient $stripeClient)
    {
        $this->stripeClient = $stripeClient;
    }

    public function show(Request $request)
    {
        $user = \Auth::user();
        $info = $user->completed_stripe_onboarding ? $this->stripeClient->balance->retrieve(null, [
            'stripe_account' => $user->stripe_connect_id
        ])->available[0]->amount : null;


        return response()->json([
            'info' => $info
        ], 200);
    }


    public function connect(Request $request)
    {
        $user = \Auth::user();

        // Complete onboarding
        if (!$user->completed_stripe_onboarding) {
            $token = Str::random(64);
            \DB::table('stripe_state_tokens')->insert([
                'created_at' => now(),
                'seller_id' => $user->id,
                'token' => $token
            ]);

            // Check stripe_connect_id
            if (is_null($user->stripe_connect_id)) {
                //Create account
                $account = $this->stripeClient->accounts->create([
                    'country' => 'GB',
                    'type' => 'express',
                    'email' => $user->email,
                ]);

                $user->update([
                    'stripe_connect_id' => $account->id
                ]);
                $user->save();
                $user = $user->fresh();
            }

            $onboardingLink = $this->stripeClient->accountLinks->create([
                'account' => $user->stripe_connect_id,
                'refresh_url' => env('SPA_URL') . '/onboarding/refresh',
                'return_url' => env('SPA_URL') . '/onboarding/success?token=' . $token,
                'type' => 'account_onboarding'
            ]);

            return redirect($onboardingLink->url);
        }

        $loginLink = $this->stripeClient->accounts->createLoginLink($user->stripe_connect_id);

        return redirect($loginLink->url);
    }

    public function completeConnection(Request $request, string $token)
    {
        $user = \Auth::user();
        $stripeToken = DB::table('stripe_state_tokens')
            ->where('created_at', '>', Carbon::now()->subMinutes(20))
            ->where('seller_id', '=', $user->id)
            ->where('token', '=', $token)
            ->first();

        if (is_null($stripeToken)) {
            return response()->json([
                'message' => 'Token does not exist or expired'
            ], 403);
        }

        $user->update([
            'completed_stripe_onboarding' => true
        ]);

        return response()->json('connected', 200);
    }
}
