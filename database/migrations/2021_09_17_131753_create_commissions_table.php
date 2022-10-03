<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description');
            $table->string('reference_url');
            $table->bigInteger('budget');
            $table->enum('status', ['pending', 'accepted', 'refused', 'inprogress', 'completed', 'declined'])->index('commissions_status_index');
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->uuid('requested_to');
            $table->foreign('requested_to')->references('id')->on('users');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}
