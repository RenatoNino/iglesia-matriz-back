<?php

namespace App\Http\Modules\IntentionType\Repositories;

use App\Http\Modules\IntentionType\Helpers\IntentionTypeHelper;
use App\Models\IntentionType;
use Exception;
use Illuminate\Http\Request;

class IntentionTypeRepository
{
    public static function list(Request $request)
    {
        return IntentionType::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('slug', 'like', "%{$request->search}%");
        })
            ->orderBy('name')
            ->get();
    }

    public static function create(Request $request)
    {
        IntentionTypeHelper::validateCreateRequest($request);

        return IntentionType::create($request->only(['name', 'slug']));
    }

    public static function update(int $id, Request $request)
    {
        IntentionTypeHelper::validateUpdateRequest($request);

        $IntentionType = IntentionType::findOrFail($id);
        $IntentionType->update($request->only(['name', 'slug']));
        return $IntentionType;
    }

    public static function delete(int $id)
    {
        $IntentionType = IntentionType::findOrFail($id);
        $IntentionType->delete();
        return $IntentionType;
    }
}
