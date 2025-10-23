<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananTiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking',
        'user_id',
        'gunung_id',
        'nama_pendaki',
        'nomor_ktp',
        'nomor_telepon',
        'email',
        'tanggal_pendakian',
        'jumlah_pendaki',
        'durasi_hari',
        'metode_pembayaran',
        'total_harga',
        'bukti_pembayaran',
        'status_pembayaran',
        'alasan_pembatalan',
        'jumlah_refund',
        'tanggal_pembatalan',
    ];

    protected $casts = [
        'tanggal_pendakian' => 'date',
        'tanggal_pembatalan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gunung()
    {
        return $this->belongsTo(Gunung::class);
    }

    public static function generateKodeBooking()
    {
        do {
            $kode = 'BK' . strtoupper(uniqid());
        } while (self::where('kode_booking', $kode)->exists());

        return $kode;
    }

    public function hitungTotalHarga()
    {
        $hargaTiket = $this->gunung->harga_tiket;
        $this->total_harga = $hargaTiket * $this->jumlah_pendaki * $this->durasi_hari;
        return $this->total_harga;
    }

    public function hitungRefund()
    {
        return $this->total_harga * 0.7;
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pembayaran', $status);
    }
}