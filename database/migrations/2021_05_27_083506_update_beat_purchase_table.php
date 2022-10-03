<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBeatPurchaseTable extends Migration
{
    public function up()
    {
        Schema::table('beat_purchase', function (Blueprint $table) {
            $table->unsignedFloat('price')->default(0.0);
        });
    }

    public function down()
    {
        Schema::table('beat_purchase', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}
