<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gunung;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        // Create sample mountains
        Gunung::create([
            'nama_gunung' => 'MT Bromo',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Probolinggo',
            'ketinggian' => 2329,
            'level_kesulitan' => 'medium',
            'gambar' => 'bromo.jpg',
            'deskripsi' => 'Mount Bromo is an active volcano located in East Java, Indonesia. It is known for its spectacular sunrise views and sea of ​​sand.',
            'harga_tiket' => 350000,
            'kuota_harian' => 100,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'MT Rinjani',
            'lokasi_provinsi' => 'Nusa Tenggara Barat',
            'lokasi_kabupaten' => 'Kabupaten Lombok Timur',
            'ketinggian' => 3726,
            'level_kesulitan' => 'hard',
            'gambar' => 'rinjani.jpg',
            'deskripsi' => 'Mount Rinjani is the second-highest active volcano in Indonesia. It is famous for its Segara Anak Lake and breathtaking views.',
            'harga_tiket' => 500000,
            'kuota_harian' => 50,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'MT Semeru',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Lumajang',
            'ketinggian' => 3676,
            'level_kesulitan' => 'hard',
            'gambar' => 'semeru.jpg',
            'deskripsi' => 'Mount Semeru is the highest mountain on the island of Java. Known as Mahameru, it offers a challenging climb with breathtaking views.',
            'harga_tiket' => 450000,
            'kuota_harian' => 30,
            'status' => 'active'
        ]);
    }
}
