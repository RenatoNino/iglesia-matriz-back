<?php

namespace App\Http\Modules\Auth\UseCases;

use App\Http\Modules\Auth\Repositories\RoleRepository;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUseCases
{
    public static function list(Request $request)
    {
        try {
            $result = RoleRepository::list($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function change(int $id)
    {
        DB::beginTransaction();
        try {
            $result = RoleRepository::change($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }
}
