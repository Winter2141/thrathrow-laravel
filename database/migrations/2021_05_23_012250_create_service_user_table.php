<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceUserTable extends Migration
{
    public function up()
    {
        Schema::create('service_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('service_id')->references('id')->on('services');
            //
            $table->unique(['service_id', 'user_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_user');
    }
}
