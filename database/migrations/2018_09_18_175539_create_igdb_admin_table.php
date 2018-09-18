<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgdbAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('igdb_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('igdb_id', 256);
            $table->string('endpoint', 256);
            $table->string('slug', 256);
            $table->string('name', 256);
            $table->unsignedInteger('status')->default(0);
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
        Schema::dropIfExists('igdb_admin');
    }
}
