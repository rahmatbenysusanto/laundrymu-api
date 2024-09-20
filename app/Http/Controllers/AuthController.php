<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'success'   => true,
                'message'   => 'Create User Successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
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
                'success'   => true,
                'message'   => 'Login Successfully',
                'data'      => $user
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'success'   => false,
                'message'   => 'Login Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
