<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganHasTransaksi extends Model
{
    use HasFactory;
    protected $table = "pelanggan_has_transaksi";
    protected $fillable = ["pelanggan_id", "jumlah_transaksi", "jumlah_transaksi_bulanan", "nominal_transaksi", "nominal_transaksi_bulanan"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
