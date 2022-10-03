<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBpmToBeats extends Migration
{
    public function up()
    {
        Schema::table('beats', function (Blueprint $table) {
            $table->unsignedSmallInteger('bpm')->default(60);
            $table->index(['bpm', 'price'], 'bpm_price');
        });
    }

    public function down()
    {
        Schema::table('beats', function (Blueprint $table) {
            $table->dropColumn('bpm');
            $table->dropIndex('bpm_price');
        });
    }
}
