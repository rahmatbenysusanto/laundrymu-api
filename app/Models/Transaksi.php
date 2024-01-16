<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = ['toko_id', 'pelanggan_id', 'diskon_id', 'pengiriman_id', 'pembayaran_id', 'order_number', 'status', 'status_pembayaran', 'harga', 'harga_diskon', 'total_harga'];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pengiriman(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pengiriman::class);
    }

    public function pembayaran(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function historiStatusTransaksi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HistoriStatusTransaksi::class);
    }
}
