<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranOutlet extends Model
{
    use HasFactory;
    protected $table = "pembayaran_outlet";
    protected $fillable = ["toko_id", "user_id", "nomor_pembayaran", "lisensi_id", "metode_pembayaran_id", "status", "bukti_transfer", "keterangan", "before", "after"];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toko(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }

    public function lisensi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lisensi::class);
    }

    public function pembayaran(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id', 'id');
    }
}
