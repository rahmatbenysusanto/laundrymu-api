<?php

namespace App\Http\Repository;

use App\Models\PaymentMethod;

class PaymentMethodRepository
{
    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return PaymentMethod::all();
    }
}
