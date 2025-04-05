<?php

namespace App\Http\Modules\MassSchedule\UseCases;

use App\Http\Modules\MassSchedule\Repositories\MassScheduleRepository;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Support\Facades\DB;

class MassScheduleUseCases
{
    public static function list()
    {
        try {
            $result = MassScheduleRepository::list();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function create($request)
    {
        DB::beginTransaction();
        try {
            $result = MassScheduleRepository::create($request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $result = MassScheduleRepository::update($request, $id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = MassScheduleRepository::delete($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }
}
