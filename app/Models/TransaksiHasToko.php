<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiHasToko extends Model
{
    use HasFactory;
    protected $table = "transaksi_has_toko";
    protected $fillable = ["toko_id", "jumlah_transaksi", "nominal_transaksi", "waktu"];
}
