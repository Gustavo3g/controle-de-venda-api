<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Exception;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {

            if($request->session()->get("token")) {
                $user = $request->session()->get("token");
            } else {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['success' => false, 'message' => 'Token Inválido']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['success' => false, 'message' => 'Expired Token']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Authentication token not found']);
                }
            }
        }
        return $next($request);
    }
}
