<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Beat;
use App\Models\Cart;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Cart $cart
     * @return CartResource
     */
    public function show()
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
        $cart->beats;

        return new CartResource($cart);
    }

    public function add(Request $request, Beat $beat)
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

        $cart->beats()->attach($beat->id, [
            'created_at' => Carbon::now(),
            'price' => $beat->price,
        ]);

        $cart->beats;
        return new CartResource($cart);
    }

    public function remove(Request $request, Beat $beat)
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

        $cart->beats()->detach([$beat->id]);

        $cart->beats;
        return new CartResource($cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
