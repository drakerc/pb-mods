<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificationRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modification_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('modification_id')->unsigned();
            $table->foreign('modification_id')->references('id')->on('modifications')->onDelete('cascade');
            $table->integer('rating');
            $table->integer('rating_usability');
            $table->integer('rating_fun');
            $table->integer('rating_quality');
            $table->text('description');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users');
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
        Schema::dropIfExists('modification_ratings');
    }
}
