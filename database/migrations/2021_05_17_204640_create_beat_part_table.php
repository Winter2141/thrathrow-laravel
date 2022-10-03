<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeatPartTable extends Migration
{
    public function up()
    {
        Schema::create('beat_part', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('part_id')->references('id')->on('parts');
            $table->foreignUuid('beat_id')->references('id')->on('beats');
            //
            $table->unique(['beat_id', 'part_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beat_part');
    }
}
