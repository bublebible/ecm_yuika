<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cara Merawat Wig Cosplay',
                'slug' => 'Cara-merawat-wig-cosplay',
                'content' => 'Tips mencuci dan menyisir wig agar tidak kusut...',
                'image' => null,
            ],
            [
                'title' => 'Memilih Kostum untuk Pemula',
                'slug' => 'memilih-kostum-pemula',
                'content' => 'Jangan ragu untuk memulai! Pilih karakter yang simpel...',
                'image' => null,
            ],
        ];

        foreach ($posts as $post) {
            \App\Models\Post::firstOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
