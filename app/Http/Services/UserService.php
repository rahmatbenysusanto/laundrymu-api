<?php

namespace App\Http\Services;

use App\Http\Repository\UserRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ){}

    public function create($request): void
    {
        $this->userRepository->create([
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password, ['rounds' => 12]),
            'status'    => $request->status
        ]);
    }

    public function login($request)
    {
        $request->validate([
            'no_hp'     => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('no_hp', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->find($request->no_hp);
            $payload = [
                'iss' => [
                    'id'    => $user->id,
                    'email' => $user->email,
                    'role'  => $user->role
                ],
                'aud' => $user->email,
                'iat' => round(microtime(true) * 1000),
                'nbf' => strtotime(date('Y-m-d H:i:s', strtotime('+15 days'))) * 1000
            ];

            $token = $this->generateTokenJWT($payload);

            return [
                'token' => $token,
                'type'  => 'bearer',
                'id'    => $user->id,
                'nama'  => $user->nama,
                'no_hp' => $user->no_hp,
                'role'  => $user->role
            ];
        } else {
            abort(400, "Login Gagal, silahkan cek no hp atau password anda");
        }
    }

    private function generateTokenJWT($payload): string
    {
        return JWT::encode($payload, file_get_contents(base_path('private.pem')), 'RS256');
    }
}
