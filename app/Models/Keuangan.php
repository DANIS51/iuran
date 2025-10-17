<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
protected $fillable = ['tipe', 'keterangan', 'jumlah', 'tanggal', 'pembayaran_id'];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
