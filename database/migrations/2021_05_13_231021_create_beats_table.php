<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeatsTable extends Migration
{
    public function up()
    {
        Schema::create('beats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->string('artwork_url')->nullable();
            $table->string('play_url')->nullable();
            $table->string('download_url')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->unsignedFloat('price');
            $table->unsignedInteger('duration')->nullable();
            $table->boolean('is_free');
            $table->boolean('is_exclusive');
            $table->boolean('download_enabled');
            $table->boolean('purchase_enabled');#
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->smallInteger('status'); //['UNPRINTED', 'AVAILABLE', 'INACTIVE', 'PURCHASED' ]
            $table->softDeletes();
            //
            $table->string('old_id')->unique()->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['is_exclusive']);
            $table->index(['is_free']);
            $table->index(['download_enabled']);
            $table->index(['purchase_enabled']);
            $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('beats');
    }
}
