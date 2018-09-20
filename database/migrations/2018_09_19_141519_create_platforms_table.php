<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('igdb_id', 256);
            $table->string('name', 256);
            $table->string('slug', 256);
            $table->string('logo', 256)->nullable();
            $table->date('release_date')->nullable();
            $table->string('website', 256)->nullable();
            $table->text('summary')->nullable();
            $table->string('alternative_name', 256)->nullable();
            $table->integer('generation')->nullable();
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
        Schema::dropIfExists('platforms');
    }
}
