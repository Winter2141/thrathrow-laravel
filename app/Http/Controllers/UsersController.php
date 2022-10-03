<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    public function show(Request $request, string $userId)
    {
        $user = User::with(['beats'])
            ->where('id', '=', $userId)
            ->firstOrFail();

        return new UserResource($user);
    }
}
