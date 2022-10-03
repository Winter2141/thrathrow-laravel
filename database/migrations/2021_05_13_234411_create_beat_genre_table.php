<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeatGenreTable extends Migration
{
    public function up()
    {
        Schema::create('beat_genre', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('genre_id')->references('id')->on('genres');
            $table->foreignUuid('beat_id')->references('id')->on('beats');
            //
            $table->unique(['beat_id', 'genre_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beat_genre');
    }
}
