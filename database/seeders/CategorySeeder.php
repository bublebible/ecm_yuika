<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Anime', 'image' => null, 'description' => 'Japanese animation costumes'],
            ['name' => 'Game', 'image' => null, 'description' => 'Video game character costumes'],
            ['name' => 'Movie', 'image' => null, 'description' => 'Hollywood and local movie costumes'],
            ['name' => 'Superhero', 'image' => null, 'description' => 'Marvel, DC, and other heroes'],
            ['name' => 'Tradisional', 'image' => null, 'description' => 'Pakaian adat dan budaya'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'image' => $cat['image'],
                    'description' => $cat['description']
                ]
            );
        }
    }
}
