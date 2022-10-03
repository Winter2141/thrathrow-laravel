<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BeatsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProducersController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return new UserResource($request->user());
//});

Route::get('/user', [UsersController::class, 'profile'])
    ->middleware('auth:sanctum')
    ->name('user.profile');

Route::group(['prefix' => 'users'], function () {
    Route::get('/{userId}', [UsersController::class, 'show'])
        ->name('user.show');
});


Route::group(['prefix' => 'trending'], function () {
    Route::get('/beats', [BeatsController::class, 'trending'])
        ->name('beats.trending');
    Route::get('/producers', [ProducersController::class, 'trending'])
        ->name('producers.trending');
});

Route::group(['prefix' => 'latest'], function () {
    Route::get('/beats', [BeatsController::class, 'latest'])
        ->name('beats.latest');
});

Route::group(['prefix' => 'genres'], function () {
    Route::get('/', [GenresController::class, 'index'])
        ->name('genres.list');
});

Route::group(['prefix' => 'parts'], function () {
    Route::get('/', [PartsController::class, 'index'])
        ->name('parts.list');
});

Route::group(['prefix' => 'uploads'], function () {
    Route::post('');
});
Route::group(['prefix' => 'beats'], function () {
    Route::post('/', [BeatsController::class, 'store'])
        ->name('beats.create')
        ->middleware(['auth:sanctum', 'verified']);
    Route::post('/imprint/{beat}', [BeatsController::class, 'imprintConfirm'])
        ->name('beats.imprint.confirm');
    Route::get('/{beatId}', [BeatsController::class, 'show'])
        ->name('beats.show');
    Route::get('/{beatId}/comments', [CommentsController::class, 'index'])
        ->name('beats.comments.show');
    Route::post('/{beat}/comments', [BeatsController::class, 'store'])
        ->middleware('auth:sanctum')
        ->middleware('verified')
        ->name('beats.comments.create');
    Route::put('/{beatId}/comments/{comment}', [BeatsController::class, 'update'])
        ->middleware('auth:sanctum')
        ->middleware('verified')
        ->name('beats.comments.update');
    Route::post('/{beatId}/comments/{comment}/likes', [LikesController::class, 'store'])
        ->middleware('auth:sanctum')
        ->middleware('verified')
        ->name('beats.comments.like');
    Route::delete('/{beatId}/comments/{comment}/likes', [LikesController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->middleware('verified')
        ->name('beats.comments.like');
});
Route::group(['prefix' => 'purchases', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/{beatId}/download_url', [PurchasesController::class, 'downloadUrl'])
        ->name('purchases.download_url');
    Route::post('/start', [PurchasesController::class, 'start'])
        ->name('purchases.start');
});

Route::group(['prefix' => 'search'], function () {
    Route::get('/producers', [SearchController::class, 'producers'])
        ->name('search.producers');
    Route::get('/beats', [SearchController::class, 'beats'])
        ->name('search.beats');
});

Route::group(['prefix' => 'carts', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', [CartsController::class, 'show'])
        ->name('carts.show');
    Route::put('/{beat}/add', [CartsController::class, 'add'])
        ->name('carts.add');
    Route::put('/{beat}/remove', [CartsController::class, 'remove'])
        ->name('carts.remove');
});

//Route::group(['prefix' => 'accounts', 'middleware' => ['auth:sanctum', 'verified']], function () {
//    Route::get('/', [AccountController::class, 'show'])
//        ->name('accounts.get');
//    Route::get('/connect', [AccountController::class, 'connect'])
//        ->name('accounts.connect');
//    Route::get('/connect/{token}/complete', [AccountController::class, 'connect'])
//        ->name('accounts.connect.complete');
//});

//Route::group(['prefix' => 'stripe'], function () {
//    Route::post('/webhook', [StripeController::class, 'webhook'])
//        ->name('stripe.webhook');
//});


Route::group(['prefix' => 'paypal', 'middleware' => ['auth:sanctum', 'verified']], function () {
   Route::get('/onboarding_link', [PaypalController::class, 'createOnboardingLink'])
       ->name('paypal.create.onboarding_link');
   Route::post('/complete_onboarding', [PaypalController::class, 'completeOnboarding'])
       ->name('paypal.onboarding.complete');
   Route::post('/create_order', [PaypalController::class, 'createOrder'])
       ->name('paypal.create_order');
    Route::post('/capture_order/{orderId}', [PaypalController::class, 'captureOrder'])
        ->name('paypal.capture_order');
});
