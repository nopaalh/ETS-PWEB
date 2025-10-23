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

    // 🔹 Relasi ke tabel favorites (1 gunung bisa difavoritkan banyak user)
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // 🔹 Relasi many-to-many ke user lewat tabel favorites
    public function favoredByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
