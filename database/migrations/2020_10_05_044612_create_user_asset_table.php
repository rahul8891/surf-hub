<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('post_id');
            $table->string('name');
            $table->string('extension');
            $table->string('type');
            $table->string('mimeType');
            $table->string('size');
            $table->string('path');
            $table->enum('profile',['1','0'])->default('0')->comment('1=>Set Profile,0=>Not set profile');
            $table->enum('status',['TEMP','PENDING','ACTIVE','REJECTED','DELETED'])->default('TEMP');
            $table->enum('is_deleted',['1','0'])->default('0')->comment('1=>deleted,0=>Not deleted');
            $table->timestamps();
            $table->index(['user_id','id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
