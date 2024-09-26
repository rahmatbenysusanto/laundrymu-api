<?php

namespace App\Http\Repository;

use App\Models\Diskon;

class DiskonRepository
{
    public function find($id)
    {
        return Diskon::where('id', $id)->first();
    }

    public function getByOutletId($outlet_id)
    {
        return Diskon::where('outlet_id', $outlet_id)
            ->where('delete', 0)
            ->get();
    }

    public function create($data)
    {
        return Diskon::create($data);
    }

    public function update($id, $data): void
    {
        Diskon::where('id', $id)->update($data);
    }
}
