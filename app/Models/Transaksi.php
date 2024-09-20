<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    public $timestamps = false;
    protected $fillable = ['outlet_id', 'pelanggan_id', 'diskon_id', 'pengiriman_id', 'pembayaran_id', 'order_number', 'status', 'status_pembayaran', 'harga', 'harga_diskon',
        'biaya_pengiriman', 'total_harga', 'catatan', 'created_at', 'updated_at'];

    public function setCreatedAt($value): void
    {
        $this->attributes['created_at'] = now()->timestamp * 1000;
    }

    public function setUpdatedAt($value): void
    {
        $this->attributes['updated_at'] = now()->timestamp * 1000;
    }

    protected $casts = [
        'created_at' => 'integer',
        'updated_at' => 'integer',
    ];

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan_id');
    }


}
