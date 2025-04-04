<?php

namespace App\Http\Modules\MassType\UseCases;

use App\Http\Modules\MassType\Repositories\MassTypeRepository;
use App\Http\Modules\MassType\Helpers\MassTypeHelper;
use App\Http\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MassTypeUseCases
{
    public static function list(Request $request)
    {
        try {
            $result = MassTypeRepository::list($request);
            return ResponseUtil::success($result);
        } catch (Exception $e) {
            return ResponseUtil::error($e->getMessage());
        }
    }

    public static function create(Request $request)
    {
        DB::beginTransaction();
        try {
            MassTypeHelper::validateCreateRequest($request);
            $result = MassTypeRepository::create($request);
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
            MassTypeHelper::validateUpdateRequest($request);
            $result = MassTypeRepository::update($id, $request);
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
            $result = MassTypeRepository::delete($id);
            DB::commit();
            return ResponseUtil::success($result, 'Tipo de misa eliminado correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseUtil::error($e->getMessage());
        }
    }
}
