<?php

namespace App\Http\Modules\SystemConfiguration\UseCases;

use App\Http\Modules\SystemConfiguration\Repositories\SystemConfigurationRepository;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemConfigurationUseCases
{
    public static function general()
    {
        try {
            $result = SystemConfigurationRepository::general();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function list()
    {
        try {
            $result = SystemConfigurationRepository::list();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function update(string $key, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = SystemConfigurationRepository::update($key, $request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function uploadImage(Request $request)
    {
        try {
            $result = SystemConfigurationRepository::uploadImage($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function deleteImage(Request $request)
    {
        try {
            $result = SystemConfigurationRepository::deleteImage($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }
}
