<?php

namespace App\Http\Repository;

use App\Models\Laporan;

class LaporanRepository
{
    public function findByUserId($user_id)
    {
        return Laporan::where('user_id', $user_id)->get();
    }

    public function update($id, $data): void
    {
        Laporan::where('id', $id)->update($data);
    }

    public function create($data): void
    {
        Laporan::create($data);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Laporan::with(['user' => function ($user) {
            $user->select([
                'id',
                'nama',
                'no_hp',
                'email'
            ]);
        }])->get();
    }
}
