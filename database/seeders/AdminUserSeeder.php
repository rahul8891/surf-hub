<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * in this seeder we are creating the default admnin user 
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_name' => 'jhonward',           
            'email' => 'jhon@yopmail.com',
            'password' => Hash::make('Admin@123'),
            'temp_password'=>Hash::make('Admin@123'),         
            'user_type'=>'ADMIN',
            'status'=>'ACTIVE',
            'account_type'=>'PRIVATE',
            'email_verified_at'=> Carbon::now(),
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 1,           
            'first_name' => 'jhon',
            'last_name' => 'ward',
            'gender'=>'M',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

    }
}