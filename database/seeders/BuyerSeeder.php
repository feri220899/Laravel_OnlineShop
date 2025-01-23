<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=BuyerSeeder
            User::create([
                'name' => 'Buyer2 User', // Contoh: Admin User
                'email' => 'buyer2@example.com', // Contoh: admin@example.com
                'password' => Hash::make('@Password123'), // Hashing password
                'address' => 'Gn. Terang, Air Hitam, Kabupaten Lampung Barat, Lampung 34871', // Hashing password
                'role' => 'buyer',
            ]);
    }
}
