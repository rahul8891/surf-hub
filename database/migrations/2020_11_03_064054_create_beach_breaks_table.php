<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeachBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beach_breaks', function (Blueprint $table) {
            $table->id();
            $table->string('beach_name')->nullable();
            $table->string('break_name')->nullable();
            $table->string('city_region')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->char('country_code', 4)->nullable();
            $table->smallInteger('flag')->default('1')->comment('1=>active,0=>deleted'); 
            $table->timestamps();
            $table->index(['beach_name','break_name']);
            // ALTER TABLE `beach_breaks` ADD INDEX(`city_region`);
            // ALTER TABLE `beach_breaks` ADD INDEX(`state`);
            // ALTER TABLE `beach_breaks` ADD INDEX(`country`);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beach_breaks');
    }
}