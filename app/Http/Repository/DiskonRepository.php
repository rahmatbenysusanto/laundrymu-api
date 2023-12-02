<?php

namespace App\Http\Repository;

use App\Models\Diskon;

class DiskonRepository
{
    public function findByToko($toko_id)
    {
        return Diskon::where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Diskon::where('id', $id)->first();
    }

    public function create($data): void
    {
        Diskon::create($data);
    }

    public function edit($id, $data): void
    {
        Diskon::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Diskon::where('id', $id)->delete();
    }
}
