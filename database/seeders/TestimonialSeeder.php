<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have at least one regular user to assign testimonials to
        $users = User::where('role', 'customer')->get();

        if ($users->isEmpty()) {
            // Create some dummy users if there are none
            $users = collect([
                User::firstOrCreate(
                    ['email' => 'sari@example.com'],
                    ['name' => 'Sari Rahmawati', 'password' => bcrypt('password'), 'role' => 'customer']
                ),
                User::firstOrCreate(
                    ['email' => 'budi@example.com'],
                    ['name' => 'Budi Santoso', 'password' => bcrypt('password'), 'role' => 'customer']
                ),
                User::firstOrCreate(
                    ['email' => 'nita@example.com'],
                    ['name' => 'Nita Agustina', 'password' => bcrypt('password'), 'role' => 'customer']
                ),
                User::firstOrCreate(
                    ['email' => 'reza@example.com'],
                    ['name' => 'Reza Fauzan', 'password' => bcrypt('password'), 'role' => 'customer']
                ),
                User::firstOrCreate(
                    ['email' => 'dinda@example.com'],
                    ['name' => 'Dinda Putri', 'password' => bcrypt('password'), 'role' => 'customer']
                ),
                User::firstOrCreate(
                    ['email' => 'fajar@example.com'],
                    ['name' => 'Fajar Nugroho', 'password' => bcrypt('password'), 'role' => 'customer']
                ),
            ]);
        }

        $testimonialData = [
            [
                'rating'  => 5,
                'comment' => 'Kostumnya keren banget dan kondisinya sangat terawat! Packaging aman sampai ke tangan. Pasti sewa lagi kesini! ⭐',
            ],
            [
                'rating'  => 5,
                'comment' => 'Pelayanannya ramah, responsif banget pas nanya soal ukuran. Kostumnya wangi dan rapih, rekomen banget buat cosplayer pemula maupun veteran!',
            ],
            [
                'rating'  => 5,
                'comment' => 'Sudah sewa beberapa kali dan selalu puas. Kostumnya lengkap, detail, dan mirip banget sama karakter aslinya. Terima kasih Yuika! 🥰',
            ],
            [
                'rating'  => 4,
                'comment' => 'Pengalaman sewa di sini sangat menyenangkan. Prosesnya gampang dan kostumnya sesuai ekspektasi. Recommended!',
            ],
            [
                'rating'  => 5,
                'comment' => 'Paling suka sama kualitas kostumnya, bahan bagus dan nyaman dipakai seharian buat event. Adminnya juga sabar banget diajak diskusi pilih kostum.',
            ],
            [
                'rating'  => 4,
                'comment' => 'Kostum Spy x Family-nya keren abis! Cocok banget buat kompetisi cosplay. Harga juga terjangkau untuk kualitas segini. Wajib coba!',
            ],
        ];

        foreach ($testimonialData as $index => $data) {
            $user = $users->get($index % $users->count());

            Testimonial::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'comment' => $data['comment'],
                ],
                [
                    'user_id'     => $user->id,
                    'rental_id'   => null,
                    'rating'      => $data['rating'],
                    'comment'     => $data['comment'],
                    'is_approved' => true,
                ]
            );
        }

        $this->command->info('Testimonial seeder ran successfully! (' . count($testimonialData) . ' records)');
    }
}
