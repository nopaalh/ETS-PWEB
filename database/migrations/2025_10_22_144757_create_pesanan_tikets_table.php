<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanan_tikets', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('gunung_id')->constrained()->onDelete('cascade');
            
            // Data pesanan
            $table->string('kode_pesanan')->unique();
            $table->integer('jumlah_tiket');
            $table->date('tanggal_naik');
            $table->date('tanggal_turun');
            $table->decimal('total_harga', 12, 2);
            
            // Status & pembayaran
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('metode_bayar', ['transfer', 'cash'])->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index('user_id');
            $table->index('gunung_id');
            $table->index('status');
            $table->index('tanggal_naik');
            $table->index('kode_pesanan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_tikets');
    }
};