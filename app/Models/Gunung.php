<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gunung extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gunung',
        'lokasi_provinsi',
        'lokasi_kabupaten',
        'ketinggian',
        'level_kesulitan',
        'gambar',
        'deskripsi',
        'harga_tiket',
        'kuota_harian',
        'status'
    ];
}
