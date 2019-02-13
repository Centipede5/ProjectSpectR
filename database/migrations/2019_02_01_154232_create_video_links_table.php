<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('igdb_id');
            $table->string('type');   // trailer, clip, movie, documentary, guide, soundtrack, other
            $table->string('title');
            $table->text('full_link');
            $table->string('site');
            $table->string('video_id');
            $table->text('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('votes')->default(0);
            $table->tinyinteger('spam_flag')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->foreign('igdb_id')->references('igdb_id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_links');
    }
}
