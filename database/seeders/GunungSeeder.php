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

        Gunung::create([
            'nama_gunung' => 'Gunung Merapi',
            'lokasi_provinsi' => 'Daerah Istimewa Yogyakarta',
            'lokasi_kabupaten' => 'Kabupaten Sleman',
            'ketinggian' => 2914,
            'level_kesulitan' => 'medium',
            'gambar' => 'merapi.jpg',
            'deskripsi' => 'Gunung Merapi adalah gunung berapi aktif yang terletak di perbatasan Jawa Tengah dan Daerah Istimewa Yogyakarta. Dikenal sebagai gunung paling aktif di Indonesia.',
            'harga_tiket' => 300000,
            'kuota_harian' => 80,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Merbabu',
            'lokasi_provinsi' => 'Jawa Tengah',
            'lokasi_kabupaten' => 'Kabupaten Magelang',
            'ketinggian' => 3145,
            'level_kesulitan' => 'medium',
            'gambar' => 'merbabu.jpg',
            'deskripsi' => 'Gunung Merbabu adalah gunung berapi yang terletak di Jawa Tengah. Menawarkan pendakian yang menantang dengan pemandangan yang luar biasa dari puncaknya.',
            'harga_tiket' => 250000,
            'kuota_harian' => 60,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Lawu',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Karanganyar',
            'ketinggian' => 3265,
            'level_kesulitan' => 'medium',
            'gambar' => 'lawu.jpg',
            'deskripsi' => 'Gunung Lawu adalah gunung berapi yang terletak di perbatasan Jawa Tengah dan Jawa Timur. Dikenal dengan legenda dan pemandangan yang indah.',
            'harga_tiket' => 200000,
            'kuota_harian' => 70,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Arjuno-Welirang',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Malang',
            'ketinggian' => 3339,
            'level_kesulitan' => 'hard',
            'gambar' => 'arjuno.jpg',
            'deskripsi' => 'Gunung Arjuno-Welirang adalah kompleks gunung berapi di Jawa Timur. Menawarkan pendakian yang menantang dengan hutan hujan tropis yang lebat.',
            'harga_tiket' => 400000,
            'kuota_harian' => 40,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Kelud',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Kediri',
            'ketinggian' => 1731,
            'level_kesulitan' => 'easy',
            'gambar' => 'kelud.jpg',
            'deskripsi' => 'Gunung Kelud adalah gunung berapi aktif yang terletak di Jawa Timur. Dikenal dengan letusan dahsyatnya dan danau kawah yang indah.',
            'harga_tiket' => 150000,
            'kuota_harian' => 90,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Ijen',
            'lokasi_provinsi' => 'Jawa Timur',
            'lokasi_kabupaten' => 'Kabupaten Banyuwangi',
            'ketinggian' => 2386,
            'level_kesulitan' => 'medium',
            'gambar' => 'ijen.jpg',
            'deskripsi' => 'Gunung Ijen terkenal dengan blue fire fenomena dan danau asamnya. Terletak di perbatasan Jawa Timur dan Bali.',
            'harga_tiket' => 350000,
            'kuota_harian' => 50,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Prau',
            'lokasi_provinsi' => 'Jawa Barat',
            'lokasi_kabupaten' => 'Kabupaten Bandung Barat',
            'ketinggian' => 2565,
            'level_kesulitan' => 'medium',
            'gambar' => 'prau.jpg',
            'deskripsi' => 'Gunung Prau adalah gunung yang terletak di Jawa Barat. Dikenal dengan pemandangan sunrise yang spektakuler dan trek yang menantang.',
            'harga_tiket' => 200000,
            'kuota_harian' => 75,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Gede',
            'lokasi_provinsi' => 'Jawa Barat',
            'lokasi_kabupaten' => 'Kabupaten Cianjur',
            'ketinggian' => 2958,
            'level_kesulitan' => 'hard',
            'gambar' => 'gede.jpg',
            'deskripsi' => 'Gunung Gede adalah gunung berapi yang terletak di Jawa Barat. Bagian dari Taman Nasional Gunung Gede Pangrango dengan keanekaragaman hayati yang tinggi.',
            'harga_tiket' => 300000,
            'kuota_harian' => 45,
            'status' => 'active'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Ciremai',
            'lokasi_provinsi' => 'Jawa Barat',
            'lokasi_kabupaten' => 'Kabupaten Kuningan',
            'ketinggian' => 3078,
            'level_kesulitan' => 'hard',
            'gambar' => 'ciremai.jpg',
            'deskripsi' => 'Gunung Ciremai adalah gunung tertinggi di Jawa Barat. Dikenal dengan keindahan alamnya dan sebagai tempat ziarah spiritual.',
            'harga_tiket' => 250000,
            'kuota_harian' => 55,
            'status' => 'active'
        ]);
    }
}
