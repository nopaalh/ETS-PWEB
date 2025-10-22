<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananTiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gunung_id', 
        'kode_pesanan',
        'jumlah_tiket',
        'tanggal_naik',
        'tanggal_turun',
        'total_harga',
        'status',
        'metode_bayar',
        'bukti_bayar',
        'catatan'
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Gunung
    public function gunung()
    {
        return $this->belongsTo(Gunung::class);
    }

    // Auto generate kode_pesanan
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pesanan) {
            $pesanan->kode_pesanan = 'PNK-' . str_pad(static::count() + 1, 3, '0', STR_PAD_LEFT) . '-' . date('Y');
            $pesanan->total_harga = $pesanan->jumlah_tiket * $pesanan->gunung->harga_tiket;
        });
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}