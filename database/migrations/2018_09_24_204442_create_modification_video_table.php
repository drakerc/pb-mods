<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificationVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modification_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('modification_id')->unsigned()->index();
            $table->foreign('modification_id')->references('id')->on('modifications')->onDelete('cascade');
            $table->string('url');
            $table->boolean('availability')->default(true);
            $table->integer('uploader_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('modification_videos', function($table) {
            $table->foreign('uploader_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modification_video');
    }
}
