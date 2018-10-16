<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModificationColorFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modifications', function($table) {
            $table->string('font_color_splash_text')->nullable();
            $table->string('color_splash_background')->nullable();
            $table->float('transparency_splash_background')->nullable();
            $table->string('font_color_description')->nullable();
            $table->string('color_description_background')->nullable();
            $table->float('transparency_description_background')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modifications', function($table) {
            $table->dropColumn('font_color_splash_text');
            $table->dropColumn('color_splash_background');
            $table->dropColumn('transparency_splash_background');
            $table->dropColumn('font_color_description');
            $table->dropColumn('color_description_background');
            $table->dropColumn('transparency_description_background');
        });
    }
}
