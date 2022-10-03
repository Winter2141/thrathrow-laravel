<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionGenreTable extends Migration
{
    public function up()
    {
        Schema::create('commission_genre', function (Blueprint $table) {
            $table->uuid('commission_id');
            $table->uuid('genre_id');
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->foreign('genre_id')->references('id')->on('genres');
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_genre');
    }
}
