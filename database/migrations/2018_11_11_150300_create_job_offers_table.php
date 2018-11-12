<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('development_studio_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->string('email');
            $table->date('valid_until');
            $table->timestamps();
        });

        Schema::table('job_offers', function (Blueprint $table) {
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
        Schema::dropIfExists('job_offers');
    }
}
