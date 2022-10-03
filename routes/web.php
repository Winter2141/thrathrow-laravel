<?php

use App\Http\Controllers\BeatsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CommissionsController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MyBeatsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProducersController;
use App\Http\Controllers\PurchasesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AuthenticateController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/admin')->group(function() {
    Route::get('/login', [AuthenticateController::class, 'login_form'])->name('admin_login');
    Route::post('/login/post', [AuthenticateController::class, 'authenticate'])->name('login_post');
    Route::get('/home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin_home');
    // ---------------------------------------
    Route::get('/user', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin_user');
    Route::post('/user/create', [App\Http\Controllers\Admin\UsersController::class, 'create'])->name('admin_create_user');
    Route::post('/user/edit/{user?}', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('admin_edit_user');
    Route::get('/user/details/{code?}', [App\Http\Controllers\Admin\UsersController::class, 'details'])->name('admin_user_details');
});


