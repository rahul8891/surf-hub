<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follows', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('followed_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('follower_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status',['FOLLOW','UNFOLLOW','BLOCK'])->default('FOLLOW');
            $table->enum('follower_request_status',['1','0'])->default('1')->comment('1=>Pending,0=>Approved');
            $table->enum('is_deleted',['1','0'])->default('0')->comment('1=>deleted,0=>Not deleted');
            $table->timestamps();
            $table->index(['followed_user_id','follower_user_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follows');
    }
}
