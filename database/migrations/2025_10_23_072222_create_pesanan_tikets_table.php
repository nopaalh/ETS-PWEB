<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan_tikets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique(); // BK001, BK002, dll
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('gunung_id')->constrained('gunungs')->onDelete('cascade');
            
            // Data Pendaki
            $table->string('nama_pendaki');
            $table->string('nomor_ktp', 16);
            $table->string('nomor_telepon', 15);
            $table->string('email');
            
            // Data Pendakian
            $table->date('tanggal_pendakian');
            $table->integer('jumlah_pendaki');
            $table->integer('durasi_hari');
            
            // Pembayaran
            $table->enum('metode_pembayaran', ['BCA', 'BRI']);
            $table->decimal('total_harga', 15, 2);
            $table->string('bukti_pembayaran')->nullable(); // path file
            $table->enum('status_pembayaran', ['menunggu', 'berhasil', 'dibatalkan'])->default('menunggu');
            
            // Pembatalan
            $table->text('alasan_pembatalan')->nullable();
            $table->decimal('jumlah_refund', 15, 2)->nullable();
            $table->timestamp('tanggal_pembatalan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_tikets');
    }
};