<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $notifications = [
            'total' => 0,
            'content' => []
        ];

        $user = $request->user();

        if ($user) {
            $notifications['total'] = $user->unreadNotifications()->count();
            $notifications['content'] = $user->unreadNotifications()->orderBy('created_at', 'desc')->limit(4)->get();
        }

        return array_merge(parent::share($request), [
            'csrf_token' => csrf_token(),
            'auth' => [
                'user' => $user? new UserResource($user) : null,
            ],
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'currentRoute' => Route::currentRouteName(),
            'notifications' => $notifications,
        ]);
    }
}
