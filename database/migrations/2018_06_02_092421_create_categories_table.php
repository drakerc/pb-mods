<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('parent')->unsigned()->nullable();
            $table->integer('author')->unsigned()->nullable();;
            $table->integer('image')->unsigned()->nullable();;
            $table->boolean('game_category')->default(true);
            $table->integer('game')->unsigned()->nullable();;
            $table->timestamps();
            $table->string('thumbnail')->nullable();
            $table->string('background')->nullable();
            // if game_category is false and parent is null, that means that a category is selected game's main mods category
            // however, game foreign key is needed in such cases so it's faster to find a suitable category
        });

        Schema::table('categories', function($table) {
            $table->foreign('parent')->references('id')->on('categories');
            $table->foreign('author')->references('id')->on('users');
            $table->foreign('image')->references('id')->on('files');
            $table->foreign('game')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('categories');
    }
}
