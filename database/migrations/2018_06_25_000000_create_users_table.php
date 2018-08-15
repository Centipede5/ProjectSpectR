<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email', 50)->unique();
            $table->string('name', 50)->nullable();
            $table->string('display_name', 20);
            $table->tinyinteger('status')->default(0);
            $table->string('uniqid', 20);
            $table->string('profile_image', 80);
            $table->string('background_image', 80);
            $table->string('password', 255);
            $table->rememberToken()->nullable();
            $table->timestamps();
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
