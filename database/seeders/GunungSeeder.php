<?php

namespace Database\Seeders;

use App\Models\Gunung;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GunungSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample mountains
        Gunung::create([
            'nama_gunung' => 'Gunung Bromo',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Probolinggo',
            'ketinggian' => 2329,
            'level_kesulitan' => 'medium',
            'gambar' => 'bromo.jpg',
            'deskripsi' => 'Gunung Bromo adalah gunung berapi aktif yang terletak di Jawa Timur, Indonesia. Dikenal dengan pemandangan sunrise yang spektakuler dan lautan pasirnya.',
            'harga_tiket' => 350000,
            'kuota_harian' => 100,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Rinjani',
            'lokasi_provinsi' => 'Nusa Tenggara Barat',
            'lokasi_kabupaten' => 'Kabupaten Lombok Timur',
            'ketinggian' => 3726,
            'level_kesulitan' => 'hard',
            'gambar' => 'rinjani.jpg',
            'deskripsi' => 'Gunung Rinjani adalah gunung berapi aktif tertinggi kedua di Indonesia. Terkenal dengan Danau Segara Anak dan pemandangan yang luar biasa.',
            'harga_tiket' => 500000,
            'kuota_harian' => 50,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Semeru',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Lumajang',
            'ketinggian' => 3676,
            'level_kesulitan' => 'hard',
            'gambar' => 'semeru.jpg',
            'deskripsi' => 'Gunung Semeru adalah gunung tertinggi di Pulau Jawa. Dikenal sebagai Mahameru, gunung ini menawarkan pendakian yang menantang dengan pemandangan yang indah.',
            'harga_tiket' => 450000,
            'kuota_harian' => 30,
            'status' => 'active'
        ]);
    }
}
