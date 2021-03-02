<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('sender_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('receiver_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('notification_type',['Post','Comment','Tag','Follow','Accept','Reject'])->default('Post');
            $table->enum('status',['0','1'])->default('0')->comment('0=>Unseen,1=>Seen');
            $table->enum('count_status',['0','1'])->default('0')->comment('0=>Uncounted,1=>Counted');
            $table->timestamps();
            $table->index(['post_id','sender_id','receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
