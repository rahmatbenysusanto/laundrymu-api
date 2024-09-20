<?php

namespace App\Http\Repository;

use App\Models\Parfum;

class ParfumRepository
{
    public function create($data)
    {
        return Parfum::create($data);
    }

    public function findById($id)
    {
        return Parfum::where('id', $id)->first();
    }

    public function findByOutletId($outlet_id)
    {
        return Parfum::where('outlet_id', $outlet_id)->get();
    }

    public function delete($id): void
    {
        Parfum::where('id', $id)->update([
            'delete'    => 1
        ]);
    }

    public function update($id, $data): void
    {
        Parfum::where('id', $id)->update($data);
    }
}
