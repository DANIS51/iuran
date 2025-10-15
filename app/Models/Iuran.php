<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nama_iuran', 'jumlah', 'periode','keterangan'];
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
