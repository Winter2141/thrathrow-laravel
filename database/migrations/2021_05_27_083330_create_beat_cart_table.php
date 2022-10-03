<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeatCartTable extends Migration
{
    public function up()
    {
        Schema::create('beat_cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('cart_id')->references('id')->on('carts');
            $table->foreignUuid('beat_id')->references('id')->on('beats');
            $table->unsignedFloat('price');
            $table->unique(['cart_id', 'beat_id']);

            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beat_cart');
    }
}
