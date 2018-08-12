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
            $table->text('description');
            $table->integer('parent')->unsigned()->nullable();
            $table->integer('author')->unsigned()->nullable();;
            $table->integer('image')->unsigned()->nullable();;
            $table->boolean('game_category')->default(true);
            $table->timestamps();
        });


        Schema::table('categories', function($table) {
            $table->foreign('parent')->references('id')->on('users');
            $table->foreign('author')->references('id')->on('users');
            $table->foreign('image')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
