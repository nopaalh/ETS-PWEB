<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Favorite;  
use App\Models\Gunung;  
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Favorites
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Cek apakah gunung sudah difavoritkan
     */
    public function hasFavorited($gunungId)
    {
        return $this->favorites()->where('gunung_id', $gunungId)->exists();
    }

    /**
     * Get all favorite gunungs
     */
    public function favoriteGunungs()
    {
        return $this->hasManyThrough(Gunung::class, Favorite::class, 'user_id', 'id', 'id', 'gunung_id');
    }
}