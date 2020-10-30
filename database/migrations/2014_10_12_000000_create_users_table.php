<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('temp_password')->nullable();
            $table->enum('user_type',['ADMIN','USER'])->default('USER'); 
            $table->enum('status',['ACTIVE','DEACTIVATED','PENDING'])->default('ACTIVE'); 
            $table->enum('account_type',['PUBLIC','PRIVATE'])->default('PUBLIC'); 	
            $table->foreignId('current_team_id')->nullable();	
            $table->text('profile_photo_path')->nullable();
            $table->text('profile_photo_name')->nullable(); 
            $table->enum('is_deleted',['1','0'])->default('0')->comment('1=>deleted,0=>Not deleted'); 
            $table->smallInteger('seen_follow_request')->default('0');
            $table->softDeletes('deleted_at', 0);
            $table->rememberToken();
            $table->index(['user_name','email']);
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
        Schema::dropIfExists('users');
    }
}