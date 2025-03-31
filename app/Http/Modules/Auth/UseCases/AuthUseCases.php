<?php

namespace App\Http\Modules\Auth\UseCases;

use App\Http\Modules\Auth\Repositories\AuthRepository;
use Exception;
use App\Http\Utils\ResponseUtil;
use Illuminate\Http\Request;

class AuthUseCases
{
    public static function login(Request $request)
    {
        try {
            $result = AuthRepository::login($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }
}
