<?php

namespace App\Http\Repository;

use App\Models\Parfum;

class ParfumRepository
{
    public function findByToko($toko_id)
    {
        return Parfum::where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Parfum::where('id', $id)->first();
    }

    public function create($data): void
    {
        Parfum::create($data);
    }

    public function edit($id, $data): void
    {
        Parfum::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Parfum::where('id', $id)->delete();
    }
}
