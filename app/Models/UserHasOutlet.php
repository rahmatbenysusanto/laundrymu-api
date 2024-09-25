<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasOutlet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_has_outlet';
    protected $fillable = ['user_id', 'outlet_id', 'created_at', 'updated_at'];

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

    public function outlet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }
}
