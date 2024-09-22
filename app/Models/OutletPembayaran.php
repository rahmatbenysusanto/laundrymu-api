<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletPembayaran extends Model
{
    use HasFactory;
    protected $table = 'outlet_pembayaran';
    protected $fillable = ['outlet_id', 'lisensi_id', 'user_id', 'nomor_pembayaran', 'status', 'url_payment', 'callback', 'created_at', 'updated_at'];
    public $timestamps = false;

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
}
