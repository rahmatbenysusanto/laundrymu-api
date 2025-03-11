<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->authService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create User Successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create User Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->authService->login($request);
            return response()->json([
                'status'    => true,
                'message'   => 'Login Successfully',
                'data'      => $user
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Login Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function verifikasiOTP(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->authService->verifikasiOTP($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Verified OTP Successfully'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::channel('auth')->error('Error Verifikasi OTP, '.$err->getMessage());
            return response()->json([
                'status'    => false,
                'message'   => 'Verifikasi OTP Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function generateNewToken(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->authService->generateNewToken($request->bearerToken());
            return response()->json([
                'status'    => true,
                'message'   => 'New Token Successfully',
                'data'      => $data
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Generate New Token Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
