<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('development_status')->default(0); // 0 - not yet started, 1 - in progress, 2 - testing, 3 - released, 4 - paused
            $table->integer('size')->default(0); // 0 - small (replaces something), 1 - medium - adds significant changes, 2 - big - completely rehauls a game
            $table->string('replaces'); // replaces what
            $table->string('version');
            $table->timestamps();
            $table->date('release_date');
            $table->integer('game_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('font_color');
            $table->integer('development_studio')->unsigned()->nullable();
            $table->boolean('use_game_background')->default(true);
        });


        Schema::table('modifications', function($table) {
//            $table->foreign('game_id')->references('id')->on('games'); // not yet created
            $table->foreign('category_id')->references('id')->on('categories');
//            $table->foreign('development_studio')->references('id')->on('development_studios'); // not yet created
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
