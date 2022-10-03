<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('comment_id')->references('id')->on('comments');

            //

            $table->timestamps();
            $table->unique(['user_id', 'comment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
