<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->text('description');
            $table->text('variant')->nullable();
            $table->integer('logo_id')->unsigned()->nullable();
            $table->integer('background_id')->unsigned()->nullable();
        });

        Schema::table('games', function (Blueprint $table) {
            $table->foreign('logo_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('background_id')->references('id')->on('files')-> onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
