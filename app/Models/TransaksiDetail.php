<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;
    protected $table = "transaksi_detail";
    protected $fillable = ["transaksi_id", "layanan_id", "parfum_id", "jumlah", "harga"];

    public function layanan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    public function parfum(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Parfum::class);
    }
}
