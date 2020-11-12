<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->char('country_code', 4)->nullable();
            $table->char('country_code2', 4)->nullable();
            $table->string('phone_code')->nullable();
            $table->string('capital')->nullable();
            $table->string('currency')->nullable();
            $table->smallInteger('flag')->default('1')->comment('1=>active,0=>deleted'); 
            $table->timestamps();
            $table->index(['name','country_code','phone_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}