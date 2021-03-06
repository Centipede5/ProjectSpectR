<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsnGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psn_games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('psn_id', 50)->unique();
            $table->string('igdb_id', 50)->nullable();
            $table->string('name', 255);
            $table->date('release_date')->nullable();
            $table->text('genres')->nullable();
            $table->string('platforms', 50)->nullable();
            $table->string('provider_name', 50)->nullable();
            $table->string('content_descriptors', 255)->nullable();
            $table->string('psn_store_url', 255)->nullable();
            $table->string('thumbnail_url_base', 255)->nullable();
            $table->text('images')->nullable();
            $table->text('videos')->nullable();
            $table->string('star_rating_score', 10)->nullable();
            $table->unsignedInteger('star_rating_count')->nullable();
            $table->string('primary_classification', 50)->nullable();
            $table->string('secondary_classification', 50)->nullable();
            $table->string('tertiary_classification', 50)->nullable();
            $table->string('ps_camera_compatibility', 50)->nullable();
            $table->string('ps_move_compatibility', 50)->nullable();
            $table->string('ps_vr_compatibility', 50)->nullable();
            $table->string('game_content_type', 20)->nullable();
            $table->string('file_size', 10)->nullable();
            $table->string('actual_price_display', 10)->nullable();
            $table->string('actual_price_value', 10)->nullable();
            $table->string('strikethrough_price_display', 10)->nullable();
            $table->string('strikethrough_price_value', 10)->nullable();
            $table->string('discount_percentage', 10)->nullable();
            $table->date('sale_start_date')->nullable();
            $table->date('sale_end_date')->nullable();
            $table->string('best_value_price', 10)->nullable();
            $table->date('best_value_date')->nullable();
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
        Schema::dropIfExists('psn_games');
    }
}
