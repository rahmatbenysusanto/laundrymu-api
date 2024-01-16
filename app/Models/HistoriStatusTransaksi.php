<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriStatusTransaksi extends Model
{
    use HasFactory;
    protected $table = "histori_status_transaksi";
    protected $fillable = ["transaksi_id", "status", "keterangan"];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
