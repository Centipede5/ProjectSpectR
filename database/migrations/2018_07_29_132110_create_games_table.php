<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 255)->unique();
            $table->string('title', 255);
            $table->string('publisher', 150)->nullable();
            $table->string('developer', 150)->nullable();
            $table->string('platforms', 255)->nullable();
            $table->text('synopsis')->nullable();
            $table->text('summary')->nullable();
            $table->string('image_profile', 255)->nullable();
            $table->string('image_landscape', 255)->nullable();
            $table->date('release_date_na')->nullable();
            $table->date('release_date_jp')->nullable();
            $table->date('release_date_eu')->nullable();
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
        Schema::dropIfExists('games');
    }
}
