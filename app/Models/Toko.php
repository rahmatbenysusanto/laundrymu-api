<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = "toko";
    protected $fillable = ["user_id", "nama", "no_hp", "logo", "status", "expired", "alamat", "provinsi", "kabupaten", "kecamatan", "kelurahan", "kode_pos", "lat", "long"];
}
