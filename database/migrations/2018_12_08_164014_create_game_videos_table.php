<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('game_id')->unsigned()->index();
            $table->string('url');
            $table->timestamps();
        });

        Schema::table('game_videos', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_videos');
    }
}
