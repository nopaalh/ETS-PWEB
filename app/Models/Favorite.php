<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    // ✅ Pastikan user_id dan gunung_id ada di sini
    protected $fillable = ['user_id', 'gunung_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gunung()
    {
        return $this->belongsTo(Gunung::class);
    }
}