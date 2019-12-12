<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user =JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof  \TymonJWTAuth\Exception\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid']);
            } else if ($e instanceof  \TymonJWTAuth\Exception\TokenExpireddException) {
                return response()->json(['status' => 'Token is Expired']);
            } else {
                return response()->json(['status' => 'Authorization Token not Found']);
            }
        }
        return $next($request);
    }
}
