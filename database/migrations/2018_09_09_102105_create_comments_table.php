<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->integer('post_id')->unsigned();
//            $table->integer('reply_id')->unsigned()->nullable();
            $table->text('body');
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
           $table->foreign('author_id')->references('id')->on('users')->delete('cascade');
           $table->foreign('post_id')->references('id')->on('posts')->delete('cascade');
//           $table->foreign('reply_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
