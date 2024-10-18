<?php

namespace App\Http\Repository;

use App\Models\User;

class UserRepository
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findByNoHp($noHp)
    {
        return User::where('no_hp', $noHp)->first();
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function findById($id)
    {
        return User::where('id', $id)->first();
    }

    public function updateById($id, $data): void
    {
        User::where('id', $id)->update($data);
    }
}
