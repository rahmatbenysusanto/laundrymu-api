<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    protected $table = 'outlet';
    public $timestamps = false;
    protected $fillable = ['user_id', 'nama', 'no_hp', 'logo', 'status', 'expired', 'alamat', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kode_pos', 'lat', 'long', 'created_at', 'updated_at'];

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
