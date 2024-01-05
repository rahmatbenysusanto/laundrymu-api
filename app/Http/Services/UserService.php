<?php

namespace App\Http\Services;

use App\Http\Repository\UserRepository;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AuthService $authService
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
        $credentials = $request->only('no_hp', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->find($request->no_hp);
            $issuedAt   = new DateTimeImmutable();
            $payload = [
                'iss' => 'laundrymu-api',
                'aud' => $user->email,
                'iat' => $issuedAt->getTimestamp(),
                'nbf' => $issuedAt->getTimestamp(),
                'data'=> [
                    'id'    => $user->id,
                    'email' => $user->email,
                    'role'  => $user->role
                ]
            ];

            $token = $this->authService->generateTokenJWT($payload);

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

    public function generateNewToken($user_id): array
    {
        $user = $this->userRepository->findById($user_id);
        return [
            'id'    => $user->id,
            'nama'  => $user->nama,
            'no_hp' => $user->no_hp,
            'role'  => $user->role
        ];
    }
}
