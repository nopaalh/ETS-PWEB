<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class GunungController extends Controller
{
    public function index()
    {
        $gunungs = [
            [
                'nama' => 'Gunung Bromo',
                'lokasi' => 'Probolinggo, Jawa Timur',
                'tinggi' => '2.329 m',
                'gambar' => 'bromo.jpg',
            ],
            [
                'nama' => 'Gunung Semeru',
                'lokasi' => 'Lumajang, Jawa Timur',
                'tinggi' => '3.676 m',
                'gambar' => 'semeru.jpg',
            ],
            [
                'nama' => 'Gunung Rinjani',
                'lokasi' => 'Lombok, NTB',
                'tinggi' => '3.726 m',
                'gambar' => 'rinjani.jpg',
            ],
            [
                'nama' => 'Gunung Prau',
                'lokasi' => 'Dieng, Jawa Tengah',
                'tinggi' => '2.565 m',
                'gambar' => 'prau.jpg',
            ],
        ];

        return view('pages.mountain.index', compact('gunungs'));
    }

    public function show($id)
    {
        $gunungs = [
            [
                'id' => 1,
                'nama' => 'Gunung Bromo',
                'lokasi' => 'Probolinggo, Jawa Timur',
                'tinggi' => '2.329 m',
                'gambar' => 'bromo.jpg',
                'deskripsi' => 'Gunung Bromo adalah salah satu ikon wisata Indonesia yang terkenal dengan keindahan kawahnya dan lautan pasir yang luas di kawasan Taman Nasional Bromo Tengger Semeru.'
            ],
            [
                'id' => 2,
                'nama' => 'Gunung Semeru',
                'lokasi' => 'Lumajang, Jawa Timur',
                'tinggi' => '3.676 m',
                'gambar' => 'semeru.jpg',
                'deskripsi' => 'Gunung Semeru merupakan gunung tertinggi di Pulau Jawa, dikenal dengan puncak Mahameru yang menjadi impian banyak pendaki untuk ditaklukkan.'
            ],
            [
                'id' => 3,
                'nama' => 'Gunung Rinjani',
                'lokasi' => 'Lombok, NTB',
                'tinggi' => '3.726 m',
                'gambar' => 'rinjani.jpg',
                'deskripsi' => 'Gunung Rinjani terkenal dengan pemandangan danau Segara Anak di kawahnya serta panorama sunrise yang memukau dari puncak.'
            ],
            [
                'id' => 4,
                'nama' => 'Gunung Prau',
                'lokasi' => 'Dieng, Jawa Tengah',
                'tinggi' => '2.565 m',
                'gambar' => 'prau.jpg',
                'deskripsi' => 'Gunung Prau adalah destinasi favorit pendaki pemula, terkenal dengan hamparan padang bunga dan panorama sunrise golden sunrise Dieng.'
            ],
        ];

        $gunung = collect($gunungs)->firstWhere('id', (int) $id);

        if (!$gunung) {
            abort(404);
        }

        return view('pages.mountain.show', compact('gunung'));
    }
}
