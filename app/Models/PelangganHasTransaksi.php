<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganHasTransaksi extends Model
{
    use HasFactory;
    protected $table = "pelanggan_has_transaksi";
    protected $fillable = ["pelanggan_id", "jumlah_transaksi", "jumlah_transaksi_bulanan", "nominal_transaksi", "nominal_transaksi_bulanan"];
}
