<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageVideoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_video_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->longText('post_text')->nullable();
            $table->enum('post_type',['PUBLIC','PRIVATE'])->default('PUBLIC'); 
            $table->smallInteger('country_id');
            $table->smallInteger('state_id');
            $table->smallInteger('wave_size');
            $table->integer('local_beach_break_id');
            $table->string('board_type')->nullable();
            $table->string('surfer')->nullable();
            $table->date('surf_start_date')->nullable();
            $table->date('surf_end_date')->nullable();
            $table->boolean('floater')->default(0);
            $table->boolean('drop_in')->default(0);
            $table->boolean('cutback')->default(0);
            $table->boolean('air')->default(0);
            $table->boolean('barrel_roll')->default(0);
            $table->boolean('snap')->default(0);
            $table->boolean('360')->default(0);
            $table->boolean('wipe_out')->default(0);
            $table->enum('is_deleted',['1','0'])->default('0')->comment('1=>deleted,0=>Not deleted');   
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_video_posts');
    }
}