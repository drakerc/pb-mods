<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificationDevelopmentStudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modification_development_studio', function (Blueprint $table) {
            $table->integer('modification_id')->unsigned()->index();
            $table->foreign('modification_id')->references('id')->on('modifications')->onDelete('cascade');
            $table->integer('development_studio_id')->unsigned()->index();
            $table->foreign('development_studio_id')->references('id')->on('development_studios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modification_development_studio');
    }
}
