<?php

namespace App\Http\Modules\IntentionType\UseCases;

use App\Http\Modules\IntentionType\Repositories\IntentionTypeRepository;
use App\Http\Modules\IntentionType\Helpers\IntentionTypeHelper;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntentionTypeUseCases
{
    public static function list(Request $request)
    {
        try {
            $result = IntentionTypeRepository::list($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function create(Request $request)
    {
        DB::beginTransaction();
        try {
            IntentionTypeHelper::validateCreateRequest($request);
            $result = IntentionTypeRepository::create($request);
            DB::commit();
            return ResponseUtil::success($result, 'Tipo de misa creado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function update(int $id, Request $request)
    {
        DB::beginTransaction();
        try {
            IntentionTypeHelper::validateUpdateRequest($request);
            $result = IntentionTypeRepository::update($id, $request);
            DB::commit();
            return ResponseUtil::success($result, 'Tipo de misa actualizado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $result = IntentionTypeRepository::delete($id);
            DB::commit();
            return ResponseUtil::success($result, 'Tipo de misa eliminado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }
}
