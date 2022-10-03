<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('price');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->timestamp('confirmed_at', 0)->nullable();
            $table->string('old_id')->nullable()->unique();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
