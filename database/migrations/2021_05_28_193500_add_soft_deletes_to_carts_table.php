<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->softDeletes();
            //
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });
    }
}
