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
}
