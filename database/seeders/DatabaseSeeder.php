<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketType;
use App\Models\User; // <--- Pastikan ini ada

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat pengguna biasa (role 'user' default)
        User::factory(10)->create();

        // Buat pengguna admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com', // <--- Gunakan email ini untuk login sebagai admin
            'role' => 'admin', // <--- Set role 'admin'
        ]);

        // Tambahkan jenis tiket awal
        TicketType::firstOrCreate(['name' => 'Reguler'], ['price' => 50000]);
        TicketType::firstOrCreate(['name' => 'VIP'], ['price' => 100000]);
        TicketType::firstOrCreate(['name' => 'Anak'], ['price' => 25000]);
    }
}