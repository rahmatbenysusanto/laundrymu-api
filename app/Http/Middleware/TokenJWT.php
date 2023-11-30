<?php

namespace App\Http\Middleware;

use App\Http\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenJWT
{
    public function __construct(
        protected AuthService $authService
    ){}

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenJWT = $request->header('tokenJWT');
        if (isset($tokenJWT)) {
            $result = $this->authService->syncTokenJWT($tokenJWT);
            if ($result) {
                return $next($request);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Token not valid'
                ], 401);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Token not valid'
            ], 401);
        }
    }
}
