<?php

namespace App\Http\Repository;

use App\Models\MetodePembayaran;

class MetodePembayaranRepository
{
    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return MetodePembayaran::all();
    }
}
