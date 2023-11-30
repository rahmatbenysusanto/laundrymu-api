<?php

namespace App\Http\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    public function generateTokenJWT($payload): string
    {
        return JWT::encode($payload, file_get_contents(base_path('private.pem')), 'RS256');
    }

    public function syncTokenJWT($token): bool
    {
        try {
            $result =  JWT::decode($token, new Key(file_get_contents(base_path('public.pem')), 'RS256'));
            if (isset($result->data)) {
                return true;
            } else {
                abort(400, "Token Failed");
            }
        } catch (\Exception $err) {
            return false;
        }
    }
}
