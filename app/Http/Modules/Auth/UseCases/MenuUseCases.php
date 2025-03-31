<?php

namespace App\Http\Modules\Auth\UseCases;

use App\Http\Modules\Auth\Repositories\MenuRepository;
use App\Http\Utils\ResponseUtil;
use Exception;

class MenuUseCases
{
    public static function get()
    {
        try {
            $result = MenuRepository::get();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }
}
