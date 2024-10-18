<?php

namespace App\Http\Service;

use App\Http\Repository\DiskonRepository;
use App\Http\Repository\LayananRepository;
use App\Http\Repository\OutletRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\PengirimanRepository;
use App\Http\Repository\UserHasOutletRepository;
use App\Http\Repository\UserRepository;
use App\Jobs\NotificationJob;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected OutletRepository $outletRepository,
        protected UserHasOutletRepository $userHasOutletRepository,
        protected ParfumRepository $parfumRepository,
        protected PembayaranRepository $pembayaranRepository,
        protected LayananRepository $layananRepository,
        protected PengirimanRepository $pengirimanRepository,
        protected DiskonRepository $diskonRepository,
    ) {}

    public function create($request): void
    {
        if ($this->userRepository->findByNoHp($request->no_hp) != null) {
            abort(400, 'Nomor HP sudah terdaftar');
        }

        $otp = random_int(100000, 999999);

        $user = $this->userRepository->create([
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'email'     => $request->email,
            'role'      => 'owner',
            'otp'       => $otp,
            'password'  => Hash::make($request->password),
            'status'    => 'inactive',
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $outlet = $this->outletRepository->create([
            'user_id'   => $user->id,
            'nama'      => $request->nama_outlet,
            'no_hp'     => $request->no_hp_outlet,
            'status'    => 'active',
            'expired'   => date('Y-m-d H:i:s', strtotime('+1 month')),
            'logo'      => 'default.png',
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->userHasOutletRepository->create([
            'outlet_id' => $outlet->id,
            'user_id'   => $user->id,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->parfumRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => '-',
            'harga'     => 0,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->pembayaranRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => 'Tunai',
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->pengirimanRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => 'Ambil antar sendiri',
            'harga'     => 0,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->diskonRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => '-',
            'type'      => 'nominal',
            'nominal'   => 0,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        NotificationJob::dispatch('user baru', [
            'no_hp' => $request->no_hp,
            'otp'   => $otp
        ]);
    }

    private function generateToken($user_id, $type): string
    {
        $user = $this->userRepository->findById($user_id);
        $exp = $type == 'token' ? (30 * 24 * 60 * 60) : (60 * 24 * 60 * 60);
        $payload = [
            'iss'       => "laundrymu",
            'sub'       => $user_id,
            'iat'       => time(),
            'exp'       => time() + $exp,
            'user_id'   => $user_id,
            'role'      => $user->role,
            'email'     => $user->email,
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login($request)
    {
        $user = $this->userRepository->findByNoHp($request->no_hp);
        if ($user && Hash::check($request->password, $user->password)) {
            return [
                'access_token'  => $this->generateToken($user->id, 'token'),
                'refresh_token' => $this->generateToken($user->id, 'refresh token'),
                'token_type'    => 'Bearer',
                'nama'          => $user->nama,
                'role'          => $user->role,
                'status'        => $user->status,
                'user_id'       => $user->id,
                'no_hp'         => $user->no_hp,
            ];
        }

        abort(400, 'User tidak ditemukan!');
    }

    public function verifikasiOTP($request): void
    {
        $otp = $request->post('otp');

        $user = $this->userRepository->findByNoHp($request->no_hp);
        if ($otp == $user->otp) {
            $this->userRepository->updateById($user->id, [
                'status'        => 'active',
                'updated_at'    => now()->timestamp * 1000,
            ]);
        }
    }
}
