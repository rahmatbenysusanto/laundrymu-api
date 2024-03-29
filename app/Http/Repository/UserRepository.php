<?php

namespace App\Http\Repository;

use App\Models\User;

class UserRepository
{
    public function create($request)
    {
        return User::create($request);
    }

    public function find($no_hp)
    {
        return User::where('no_hp', $no_hp)->first();
    }

    public function findById($id)
    {
        return User::where('id', $id)->first();
    }

    public function findByNoHp($no_hp)
    {
        return User::where('no_hp', $no_hp)->first();
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function update($id, $data)
    {
        return User::where('id', $id)->update($data);
    }

    public function getAll()
    {
        return User::select([
                'id',
                'nama',
                'no_hp',
                'email',
                'otp',
                'role',
                'status',
                'created_at'
            ])
            ->where('role', '!=', 'admin')
            ->get();
    }
}
