<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parfum extends Model
{
    use HasFactory;
    protected $table = 'parfum';
    public $timestamps = false;
    protected $fillable = ['outlet_id', 'nama', 'harga', 'delete', 'created_at', 'updated_at'];

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

//    public function getCreatedAtAttribute($value)
//    {
//        return \Carbon\Carbon::createFromTimestampMs($value);
//    }
//
//    public function getUpdatedAtAttribute($value)
//    {
//        return \Carbon\Carbon::createFromTimestampMs($value);
//    }

}
