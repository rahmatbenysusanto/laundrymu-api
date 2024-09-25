<?php

namespace App\Http\Repository;

use App\Models\StatusTransaksiOutlet;

class StatusTransaksiOutletRepository
{
    public function findByOutletId($outlet_id)
    {
        return StatusTransaksiOutlet::where('outlet_id', $outlet_id)->get();
    }
}
