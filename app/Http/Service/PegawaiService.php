<?php

namespace App\Http\Service;

use App\Http\Repository\PegawaiRepository;
use App\Http\Repository\UserHasOutletRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class PegawaiService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected UserHasOutletRepository $userHasOutletRepository,
        protected PegawaiRepository $pegawaiRepository
    ) {}

    public function create($request): void
    {
        $user = $this->userRepository->create([
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'role'      => 'pegawai',
            'password'  => Hash::make($request->password),
            'status'    => 'active',
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->pegawaiRepository->create([
            'user_id'   => $user->id,
            'outlet_id' => $request->outlet_id,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);
    }

    public function findById($id)
    {
        return true;
    }

    public function findByOutletId($outlet_id)
    {
        return true;
    }
}
