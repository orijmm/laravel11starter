<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BouncerSeeder::class,
            UsersTableSeeder::class,
            WorldSeeder::class,
            SettingSeeder::class
        ]);
    }
}
