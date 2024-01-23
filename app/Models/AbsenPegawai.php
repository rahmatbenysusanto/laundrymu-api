<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenPegawai extends Model
{
    use HasFactory;
    protected $table = "absen_pegawai";
    protected $fillable = ["toko_id", "pegawai_id", "status", "keterangan", "tanggal"];

    public function toko(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }

    public function pegawai(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'pegawai_id', 'id');
    }
}
