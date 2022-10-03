<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('content');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('beat_id')->references('id')->on('beats');
            $table->string('old_id')->nullable();
            //

            $table->timestamps();
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
