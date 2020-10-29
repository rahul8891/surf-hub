<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender',['M','F'])->nullable();
            $table->date('dob')->nullable();
            $table->string('relationship')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('suburb')->nullable();
            $table->smallInteger('country_id')->nullable();
            $table->smallInteger('state_id')->nullable();
            $table->smallInteger('city_id')->nullable();
            $table->enum('language',['en','es'])->default('en')->comment('en=>English,es=>Spanish');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->smallInteger('preferred_location')->nullable();
            $table->enum('is_deleted',['1','0'])->default('0')->comment('1=>deleted,0=>Not deleted');   
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->index(['user_id','first_name','phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}