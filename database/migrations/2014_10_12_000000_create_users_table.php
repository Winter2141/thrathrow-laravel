<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('first_name')->nullable()->default('');
            $table->string('last_name')->nullable()->default('');
            $table->string('email')->unique();
            $table->string('parent_id')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('about');
            $table->string('facebook_url')->unique()->nullable();
            $table->string('twitter_url')->unique()->nullable();
            $table->string('youtube_url')->unique()->nullable();
            $table->string('soundcloud_url')->unique()->nullable();
            $table->string('instagram_url')->unique()->nullable();
            $table->string('profile_image_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('last_login')->nullable();
            $table->string('old_id')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
