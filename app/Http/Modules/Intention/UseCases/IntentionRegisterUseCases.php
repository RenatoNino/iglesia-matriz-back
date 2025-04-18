<?php

namespace App\Http\Modules\Intention\UseCases;

use App\Http\Modules\Intention\Repositories\IntentionRegisterRepository;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntentionRegisterUseCases
{
    public static function parameters()
    {
        try {
            $result = IntentionRegisterRepository::parameters();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function list(Request $request)
    {
        try {
            $result = IntentionRegisterRepository::list($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $result = IntentionRegisterRepository::create($request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function update(Request $request, int $id)
    {
        DB::beginTransaction();
        try {
            $result = IntentionRegisterRepository::update($request, $id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function updateIntention(Request $request, int $id)
    {
        DB::beginTransaction();
        try {
            $result = IntentionRegisterRepository::updateIntention($request, $id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function deleteIntention(int $id)
    {
        DB::beginTransaction();
        try {
            $result = IntentionRegisterRepository::deleteIntention($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $result = IntentionRegisterRepository::delete($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }
}
