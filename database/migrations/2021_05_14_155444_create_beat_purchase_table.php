<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeatPurchaseTable extends Migration
{
    public function up()
    {
        Schema::create('beat_purchase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('purchase_id')->references('id')->on('purchases');
            $table->foreignUuid('beat_id')->references('id')->on('beats');
            $table->unique(['purchase_id', 'beat_id']);
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beat_purchase');
    }
}
