<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'status'    => false,
                'message'   => 'Unauthenticated.',
                'errors'    => 'Token not provided'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $request->attributes->set('auth', $credentials);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(SignatureInvalidException $e){
            return response()->json([
                'error' => 'Wrong signature token or secret key.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }

        return $next($request);
    }
}
