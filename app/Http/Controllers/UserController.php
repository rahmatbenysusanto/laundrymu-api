<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\LoginUser;
use App\Http\Services\ResponseService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected UserService $userService
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
}
