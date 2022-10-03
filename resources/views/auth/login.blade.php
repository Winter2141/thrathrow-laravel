@extends('layouts.master')

@section('content')
<div class="col-lg-6 col-12 p-0">
    <div class="card rounded-0 mb-0 px-2">
        <div class="card-header pb-1">
            <div class="card-title">
                <h4 class="mb-0">Login</h4>
            </div>
        </div>
        <p class="px-2">Welcome back, please login to your account.</p>
        <div class="card-content">
            <div class="card-body pt-1">
                <form action="{{ route('login_post') }}" method="POST">
                    @csrf
                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input type="email" class="form-control" name="email" placeholder="Enter Email">
                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>
                        <label for="user-name">Username</label>
                    </fieldset>

                    <fieldset class="form-label-group position-relative has-icon-left">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                        <label for="user-password">Password</label>
                    </fieldset>
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="text-left">
                            <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
