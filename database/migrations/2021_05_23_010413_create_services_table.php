<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            //
            $table->string('old_id')->nullable();

            $table->timestamps();
            $table->index(['old_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}
