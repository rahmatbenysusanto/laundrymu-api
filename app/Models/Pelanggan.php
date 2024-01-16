<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = "pelanggan";
    protected $fillable = ["toko_id", "nama", "no_hp"];

    public function pelangganHasTransaksi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PelangganHasTransaksi::class, 'id', 'pelanggan_id');
    }
}
