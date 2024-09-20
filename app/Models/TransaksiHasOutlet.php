<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiHasOutlet extends Model
{
    use HasFactory;
    protected $table = 'transaksi_has_outlet';
    public $timestamps = false;
    protected $fillable = ['outlet_id', 'jumlah_transaksi', 'nominal_transaksi', 'waktu', 'created_at', 'updated_at'];

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
