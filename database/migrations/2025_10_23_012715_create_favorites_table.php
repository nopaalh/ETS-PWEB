<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('gunung_id')->constrained('gunungs')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'gunung_id']); // supaya tidak bisa favorit dua kali
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
