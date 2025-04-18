<?php

namespace App\Http\Modules\Intention\Repositories;

use App\Http\Modules\Auth\Helpers\RoleHelper;
use App\Http\Modules\Intention\Helpers\IntentionHelper;
use App\Http\Modules\SystemConfiguration\Helpers\SystemConfigurationHelper;
use App\Models\Intention;
use App\Models\IntentionType;
use App\Models\MassSchedule;
use Illuminate\Http\Request;

class IntentionRepository
{
    public static function parameters()
    {
        $mass_schedules = MassSchedule::all();
        $intention_types = IntentionType::all();

        return [
            'mass_schedules' => $mass_schedules,
            'intention_types' => $intention_types,
        ];
    }

    public static function list(Request $request)
    {
        IntentionHelper::validateListRequest($request);

        $intentions = Intention::with(['massSchedule', 'intentionType'])
            ->when($request->filled('mass_date'), function ($query) use ($request) {
                $query->whereDate('mass_date', $request->mass_date);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('person_name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('mass_schedule_id'), function ($query) use ($request) {
                $query->where('mass_schedule_id', $request->mass_schedule_id);
            })
            ->orderBy('created_at')
            ->get();

        return $intentions;
    }

    public static function create(Request $request)
    {
        RoleHelper::validateAdminAccess();
        IntentionHelper::validateCreateRequest($request);

        $intention_price = SystemConfigurationHelper::getValueByKey('intention_price');

        $intention = Intention::create([
            'person_name' => $request->person_name,
            'mass_date' => $request->mass_date,
            'mass_schedule_id' => $request->mass_schedule_id,
            'intention_type_id' => $request->intention_type_id,
            'amount' => $intention_price,
        ]);

        return $intention;
    }

    public static function update(Request $request, int $id)
    {
        RoleHelper::validateAdminAccess();
        IntentionHelper::validateUpdateRequest($request);

        $intention = Intention::findOrFail($id);
        $intention->update($request->only([
            'person_name',
            'mass_date',
            'mass_schedule_id',
            'intention_type_id',
        ]));

        return $intention;
    }

    public static function delete(int $id)
    {
        RoleHelper::validateAdminAccess();
        $intention = Intention::find($id);
        if ($intention) {
            $intention->delete();
        }

        return 'Intención eliminada exitosamente';
    }
}
