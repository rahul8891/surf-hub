<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->longText('post_text')->nullable();
            $table->enum('post_type',['PUBLIC','PRIVATE'])->default('PUBLIC'); 
            $table->integer('country_id');
            $table->integer('state_id');
            $table->smallInteger('wave_size');
            $table->integer('local_beach_break_id');
            $table->string('board_type')->nullable();
            $table->string('surfer')->nullable();
            $table->date('surf_start_date')->nullable();
            $table->date('surf_end_date')->nullable();
            $table->string('optional_info')->nullable();
            $table->integer('parent_id')->nullable();
            $table->enum('is_deleted',['1','0'])->default('0')->comment('1=>deleted,0=>Not deleted');   
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->index(['user_id','country_id','state_id','optional_info','board_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}