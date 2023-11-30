<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('apiKey');
        if (isset($apiKey) && $apiKey == env('API_KEY')) {
            return $next($request);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'API key not valid'
            ], 401);
        }
    }
}
