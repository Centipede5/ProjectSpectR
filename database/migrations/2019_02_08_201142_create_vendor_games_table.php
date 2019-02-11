<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api', 10);
            $table->string('game_id', 50)->unique();
            $table->string('igdb_id', 50)->nullable();
            $table->string('title', 255);
            $table->date('release_date_na')->nullable();
            $table->text('genres')->nullable();
            $table->string('platforms', 50)->nullable();
            $table->string('publishers', 50)->nullable();
            $table->string('developers', 50)->nullable();
            $table->string('content_descriptors', 255)->nullable();
            $table->string('store_url', 255)->nullable();
            $table->string('thumbnail_url', 255)->nullable();
            $table->text('images')->nullable();
            $table->text('videos')->nullable();
            $table->string('file_size', 10)->nullable();
            $table->string('star_rating_score', 10)->nullable();
            $table->unsignedInteger('star_rating_count')->nullable();
            $table->string('game_content_type', 20)->nullable();
            $table->string('actual_price_display', 10)->nullable();
            $table->unsignedInteger('actual_price_value')->nullable();
            $table->string('msrp_price_display', 10)->nullable();
            $table->unsignedInteger('msrp_price_value')->nullable();
            $table->string('discount_percentage', 10)->nullable();
            $table->string('best_value_price', 10)->nullable();
            $table->date('best_value_date')->nullable();
            $table->string('psn_primary_classification', 50)->nullable();
            $table->string('psn_secondary_classification', 50)->nullable();
            $table->string('psn_tertiary_classification', 50)->nullable();
            $table->string('psn_ps_camera_compatibility', 50)->nullable();
            $table->string('psn_ps_move_compatibility', 50)->nullable();
            $table->string('psn_ps_vr_compatibility', 50)->nullable();
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
        Schema::dropIfExists('vendor_games');
    }
}
