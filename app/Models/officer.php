<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
