<?php

namespace App\Http\Modules\MassType\Repositories;

use App\Http\Modules\MassType\Helpers\MassTypeHelper;
use App\Models\MassType;
use Exception;
use Illuminate\Http\Request;

class MassTypeRepository
{
    public static function list(Request $request)
    {
        return MassType::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('slug', 'like', "%{$request->search}%");
        })
            ->orderBy('name')
            ->get();
    }

    public static function create(Request $request)
    {
        MassTypeHelper::validateCreateRequest($request);

        return MassType::create($request->only(['name', 'slug']));
    }

    public static function update(int $id, Request $request)
    {
        MassTypeHelper::validateUpdateRequest($request);

        $massType = MassType::findOrFail($id);
        $massType->update($request->only(['name', 'slug']));
        return $massType;
    }

    public static function delete(int $id)
    {
        $massType = MassType::findOrFail($id);
        $massType->delete();
        return $massType;
    }
}
