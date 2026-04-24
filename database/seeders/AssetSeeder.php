<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anime = \App\Models\Category::where('slug', 'anime')->first();
        $game = \App\Models\Category::where('slug', 'game')->first();

        $assets = [
            [
                'name' => 'Raiden Shogun',
                'code' => 'COS-001',
                'category_id' => $game->id ?? 1,
                'price_per_day' => 150000,
                'stock_qty' => 1,
                'description' => 'Full set Raiden Shogun Genshin Impact size L include wig.',
            ],
            [
                'name' => 'Naruto Uzumaki',
                'code' => 'COS-002',
                'category_id' => $anime->id ?? 1,
                'price_per_day' => 100000,
                'stock_qty' => 2,
                'description' => 'Kostum Naruto Shippuden size M/L.',
            ],
            [
                'name' => 'Spy x Family Anya',
                'code' => 'COS-003',
                'category_id' => $anime->id ?? 1,
                'price_per_day' => 120000,
                'stock_qty' => 1,
                'description' => 'Seragam Eden Academy Anya Forger lucu.',
            ],
        ];

        foreach ($assets as $assetData) {
            $asset = \App\Models\Asset::firstOrCreate(
                ['code' => $assetData['code']],
                $assetData
            );

            // Create Condition if not exists
            if ($asset->conditions()->count() == 0) {
                $asset->conditions()->create([
                    'version' => 1,
                    'status' => 'Good',
                    'notes' => 'Initial stock, good condition.',
                    'created_by_user_id' => 1, // Assumes Admin ID 1 exists
                    'image' => null // Placeholder
                ]);
            }
        }
    }
}
