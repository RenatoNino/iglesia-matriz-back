<?php

namespace App\Http\Middlewares;

use App\Http\Services\JWTService;
use App\Http\Services\SessionManagerService;
use App\Http\Utils\ResponseUtil;
use Closure;
use Exception;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $this->getToken($request);

            if (!$token) {
                return ResponseUtil::unauthorized();
            }

            $payload = JWTService::valid($token);

            $request->merge([SessionManagerService::JWT_SESSION => $payload]);

            return $next($request);
        } catch (Exception $e) {
            return ResponseUtil::unauthorized();
        }
    }


    private function getToken($request)
    {
        if (empty($token)) $token = $request->header('Authorization');

        if (empty($token)) $token = $request->bearerToken();

        $token = str_replace('Bearer ', '', $token);

        $token = str_replace(' ', '', $token);

        return $token;
    }
}
