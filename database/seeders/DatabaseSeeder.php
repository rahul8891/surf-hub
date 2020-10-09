<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
ini_set('memory_limit', -1);
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->run(AdminUserSeeder::class);
    }
}
