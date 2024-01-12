<?php

namespace App\Http\Services;

use App\Http\Repository\UserHasTokoRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class PegawaiService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected UserHasTokoRepository $userHasTokoRepository
    ){}

    public function getByTokoId($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->userHasTokoRepository->findByTokoId($toko_id);
    }

    public function create($request): void
    {
        if ($this->userRepository->findByNoHp($request->no_hp) != null) {
            abort(400, 'No HP telah dipakai oleh user lain');
        }

        if ($this->userRepository->findByEmail($request->email) != null) {
            abort(400, 'Email telah dipakai oleh user lain');
        }

        $user = $this->userRepository->create([
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'email'     => $request->email,
            'role'      => 'pegawai',
            'password'  => Hash::make($request->password, ['rounds' => 12]),
            'status'    => 'active'
        ]);

        $this->userHasTokoRepository->create([
            'user_id'   => $user->id,
            'toko_id'   => $request->toko_id
        ]);
    }
}
