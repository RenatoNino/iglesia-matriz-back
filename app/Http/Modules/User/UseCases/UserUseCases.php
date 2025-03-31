<?php

namespace App\Http\Modules\User\UseCases;

use App\Http\Modules\User\Repositories\UserRepository;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserUseCases
{
    public static function params()
    {
        try {
            $result = UserRepository::params();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function list(Request $request)
    {
        try {
            $result = UserRepository::list($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::create($request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function update(int $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::update($id, $request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function changePassword(int $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::changePassword($id, $request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function changePhoto(int $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::changePhoto($id, $request);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function deletePhoto(int $id)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::deletePhoto($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function resetPassword(int $id)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::resetPassword($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function disable(int $id)
    {
        DB::beginTransaction();
        try {
            $result = UserRepository::disable($id);
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
            $result = UserRepository::delete($id);
            DB::commit();
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }
}
