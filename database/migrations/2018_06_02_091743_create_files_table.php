<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size');
            $table->integer('downloads')->default(0);
            $table->boolean('availability')->default(true);
            $table->integer('uploader_id')->unsigned()->nullable();;
            $table->timestamps();
        });

        Schema::table('files', function($table) {
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
        Schema::dropIfExists('files');
    }
}
