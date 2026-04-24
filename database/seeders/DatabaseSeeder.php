<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User if not exists
        User::firstOrCreate(
            ['email' => 'admin@ecm.com'],
            [
                'name' => 'Admin Owner',
                'password' => bcrypt('password'),
                'usertype' => 'admin', // Ensure this column matches your User model/migration
            ]
        );

        $this->call([
            CategorySeeder::class,
            AssetSeeder::class,
            PostSeeder::class,
        ]);
    }
}
