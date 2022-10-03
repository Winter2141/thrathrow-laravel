<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreUserTable extends Migration
{
    public function up()
    {
        Schema::create('genre_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('genre_id')->references('id')->on('genres');
            $table->foreignUuid('user_id')->references('id')->on('users');
            //
            $table->unique(['user_id', 'genre_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('genre_user');
    }
}
