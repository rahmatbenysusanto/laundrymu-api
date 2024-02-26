<?php

namespace App\Http\Controllers;

use App\Http\Repository\TokoRepository;
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\GenerateToken;
use App\Http\Requests\User\LoginUser;
use App\Http\Services\ResponseService;
use App\Http\Services\TokoService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\LaundrymuMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected UserService $userService,
        protected TokoService $tokoService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
           'data'   => 'Hello word'
        ]);
    }

    public function create(CreateUser $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->userService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create User Successfully", 201);
        } catch (\Exception $err) {
            Log::channel('user')->error($err->getMessage());
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create user error', $err->getMessage(), 400);
        }
    }

    public function login(LoginUser $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $result = $this->userService->login($request);
            DB::commit();
            return $this->responseService->responseWithData(true, 'Login sukses', $result, 200);
        } catch (\Exception $err) {
            Log::channel('user')->error($err->getMessage());
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Login user error', $err->getMessage(), 400);
        }
    }

    public function generateNewToken($user_id): JsonResponse
    {
        $result = $this->userService->generateNewToken($user_id);
        return $this->responseService->responseWithData(true, 'Login sukses', $result, 200);
    }

    public function verifikasiOTP(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->userService->verifikasiOTP($request->post('user_id'), $request->post('otp'));
            DB::commit();
            return $this->responseService->responseNotData(true, 'Verifikasi OTP successfully', 200);
        } catch (\Exception $err) {
            Log::channel('user')->error($err->getMessage());
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Verifikasi OTP Failed', $err->getMessage(), 400);
        }
    }

    public function generateNewOTP($user_id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->userService->generateNewOTP($user_id);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Generate New OTP successfully', 200);
        } catch (\Exception $err) {
            Log::channel('user')->error($err->getMessage());
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Generate New  OTP Failed', $err->getMessage(), 400);
        }
    }

    public function lupaKataSandi(Request $request): JsonResponse
    {
        try {
            $this->userService->lupaPassword($request->post('email'));
            return $this->responseService->responseNotData(true, 'Send Mail Successfully', 200);
        } catch (\Exception $err) {
            return $this->responseService->responseNotData(false, 'Send Mail Failed, '. $err->getMessage(), 400);
        }
    }

    public function checkValidateEmail($email): JsonResponse
    {
        try {
            $this->userService->checkValidateEmail($email);
            return $this->responseService->responseNotData(true, 'Check Mail Successfully', 200);
        } catch (\Exception $err) {
            return $this->responseService->responseNotData(false, 'Check Mail Failed, '. $err->getMessage(), 400);
        }
    }

    public function gantiPassword(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->userService->gantiPassword($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Change Password Successfully', 200);
        } catch (\Exception $err) {
            return $this->responseService->responseNotData(false, 'Change Password Failed', 400);
        }
    }

    public function getAllUser(): JsonResponse
    {
        $result = $this->userService->getAllUser();
        return $this->responseService->responseWithData(true, 'Get All Pelanggan Successfully', $result, 200);
    }
}
