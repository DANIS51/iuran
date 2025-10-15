<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'no_telepon', 'jenis_kelamin'];
    public function iurans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
