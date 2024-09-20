<?php

namespace App\Http\Repository;

use App\Models\Outlet;

class OutletRepository
{
    public function create($data)
    {
        return Outlet::create($data);
    }

    public function findById($id)
    {
        return Outlet::where('id', $id)->first();
    }
}
