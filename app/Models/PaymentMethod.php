<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = "payment_method";
    protected $fillable = ["payment_code", "payment_type", "payment_desc", "payment_price_type", "payment_fee", "status"];
}
