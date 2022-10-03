<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderIdToPurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('provider_id')->unique()->nullable();
            $table->string('provider')->index()->nullable();
            $table->uuid('cart_id')->unique()->nullable();
            $table->text('receipt_url')->nullable();
            //
        });
    }

    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
            $table->dropColumn('provider_id');
            $table->dropColumn('provider');
            $table->dropColumn('cart_id');
            $table->dropColumn('receipt_url')->nullable();
        });
    }
}
