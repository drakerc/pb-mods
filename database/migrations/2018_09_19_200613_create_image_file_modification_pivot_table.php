<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageFileModificationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_file_modification', function (Blueprint $table) {
            $table->integer('file_id')->unsigned()->index();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->integer('modification_id')->unsigned()->index();
            $table->foreign('modification_id')->references('id')->on('modifications')->onDelete('cascade');
            $table->primary(['file_id', 'modification_id']);
            $table->integer('type'); // 0 - mod background, 1 - thumbnail, 2 - splash image in a container, 3 - image gallery
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_file_modification_pivot');
    }
}
