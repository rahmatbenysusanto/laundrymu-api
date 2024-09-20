<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiHistory extends Model
{
    use HasFactory;
    protected $table = 'transaksi_history';
    public $timestamps = false;
    protected $fillable = ['transaksi_id', 'status', 'keterangan', 'created_at', 'updated_at'];

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
