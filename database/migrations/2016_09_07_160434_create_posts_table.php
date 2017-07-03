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
            $table->timestamps();
            $table->string('type');
            $table->string('name');
            $table->integer('appid');
            $table->integer('required_age');
            $table->boolean('is_free');
            $table->longText('detailed_description');
            $table->longText('about_the_game');
            $table->text('short_description');
            $table->longText('reviews');
            $table->string('header_image');
            $table->string('developer');
            $table->string('publisher');
            $table->integer('recommendations');
            $table->string('support');
            $table->string('background');
            $table->boolean('is_released');
            $table->datetime('release_date');
            $table->integer('current_price');
            $table->integer('origin_price');
            $table->integer('card_price');
            $table->boolean('is_new');            
            $table->boolean('is_on_discount');
            $table->boolean('is_popular');
            $table->string('carousel_img');
            $table->string('status');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('post_has_categories', function (Blueprint $table) {
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->primary(['post_id', 'category_id']);
        });

        Schema::create('post_has_genres', function (Blueprint $table) {
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->integer('genres_id')->unsigned();
            $table->foreign('genres_id')->references('id')->on('genres')->onDelete('cascade');

            $table->primary(['post_id', 'genres_id']);
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('post_has_categories');
        Schema::dropIfExists('post_has_genres');
    }
}
