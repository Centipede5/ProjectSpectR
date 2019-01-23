<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameIdSyncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_id_sync', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('igdb_id')->unique();
            $table->string('psn_id', 50)->nullable();
            $table->string('xbox_id', 50)->nullable();
            $table->string('nintendo_id', 50)->nullable();
            $table->string('steam_id', 50)->nullable();
            $table->string('gog_id', 50)->nullable();
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
        Schema::dropIfExists('game_id_sync');
    }
}
