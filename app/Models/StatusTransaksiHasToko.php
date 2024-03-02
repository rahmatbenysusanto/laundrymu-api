<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTransaksiHasToko extends Model
{
    use HasFactory;
    protected $table = "status_transaksi_has_toko";
    protected $fillable = ["toko_id", "baru", "diproses", "selesai"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
