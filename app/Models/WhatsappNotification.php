<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappNotification extends Model
{
    use HasFactory;
    protected $table = 'whatsapp_notification';
    protected $fillable = ['no_hp', 'message', 'status', 'created_at', 'updated_at'];
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
