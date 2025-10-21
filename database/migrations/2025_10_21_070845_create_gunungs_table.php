<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('gunungs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_gunung');
        $table->string('lokasi_provinsi');
        $table->string('lokasi_kabupaten');
        $table->unsignedInteger('ketinggian');
        $table->enum('level_kesulitan', ['easy', 'medium', 'hard']);
        $table->string('gambar')->nullable();
        $table->text('deskripsi');
        $table->decimal('harga_tiket', 10, 2);
        $table->integer('kuota_harian');
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
        
        // Indexes
        $table->index('lokasi_provinsi');
        $table->index('level_kesulitan');
        $table->index('status');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gunungs');
    }
};