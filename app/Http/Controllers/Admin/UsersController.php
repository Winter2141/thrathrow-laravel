<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $user = User::orderBy('id', 'DESC')
                ->where('parent_id', '!=', 0)
                ->get();
        return view('user.index', compact('user'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email'     => 'required|unique:users,email',
            'password' => 'required|string|min:4|confirmed'
        ]);

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->parent_id = 1;
        $user->save();
        return redirect()->back()->with('success', __('User created succesfully'));
    }

    public function edit(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email'     => 'required|string',
            'password' => 'required|string|min:4|confirmed'
        ]);

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->parent_id = 1;
        $user->save();
        return redirect()->back()->with('success', __('User updated succesfully'));
    }

    public function details(Request $request)
    {
        $code = Crypt::decrypt($request->code);
        $user = User::findorfail($code);
        return view('user.details', compact('user'));
    }
}
