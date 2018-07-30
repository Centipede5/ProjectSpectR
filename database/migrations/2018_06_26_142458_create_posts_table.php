<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_parent');
            $table->unsignedInteger('user_id');
            $table->string('post_type')->nullable();
            $table->string('post_title');
            $table->string('slug')->unique();
            $table->text('post_content');
            $table->text('post_excerpt');
            $table->tinyinteger('post_status')->default(0);
            $table->boolean('published')->default(false);
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('comment_count');
            $table->tinyinteger('spam_flag')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
