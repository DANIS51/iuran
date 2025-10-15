<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    //
    use HasFactory;

     protected $fillable = ['warga_id', 'iuran_id', 'tanggal_bayar', 'status', 'jumlah'];

     public function warga(){
        return $this->belongsTo(Warga::class);
     }
     public function iuran(){
        return $this->belongsTo(Iuran::class);
     }
}
