<?php

namespace App\Http\Modules\Intention\Repositories;

use App\Http\Modules\Auth\Enums\RoleEnum;
use App\Http\Modules\Intention\Helpers\IntentionRegisterHelper;
use App\Http\Modules\SystemConfiguration\Helpers\SystemConfigurationHelper;
use App\Http\Services\SessionManagerService;
use App\Models\Intention;
use App\Models\IntentionRegister;
use App\Models\IntentionType;
use App\Models\MassSchedule;
use App\Models\PaymentMethod;
use App\Models\PaymentReceipt;
use App\Models\ReceiptNumberSequence;
use App\Models\ReceiptType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class IntentionRegisterRepository
{
    public static function parameters()
    {
        $mass_schedules = MassSchedule::all();
        $intention_types = IntentionType::all();
        $payment_methods = PaymentMethod::all();
        $receipt_types = ReceiptType::all();
        $intention_price = SystemConfigurationHelper::getValueByKey('intention_price');

        return [
            'mass_schedules' => $mass_schedules,
            'intention_types' => $intention_types,
            'payment_methods' => $payment_methods,
            'receipt_types' => $receipt_types,
            'intention_price' => $intention_price,
        ];
    }

    public static function list(Request $request)
    {
        IntentionRegisterHelper::validateListRequest($request);

        $registers = IntentionRegister::with(['registerBy', 'intentions', 'paymentReceipt'])
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('client_name', 'like', '%' . $request->search . '%')
                        ->orWhere('client_phone', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->paginate($request->size, ['*'], 'page', $request->page);

        return [
            'page' => $request->page,
            'size' => $request->size,
            'total' => $registers->total(),
            'data' => $registers->items(),
        ];
    }

    public static function create(Request $request)
    {
        $session = SessionManagerService::get();
        $user = User::where('id', $session->user_id)->first();

        IntentionRegisterHelper::validateCreateRequest($request, $user);

        // Intention Register
        $intention_price = SystemConfigurationHelper::getValueByKey('intention_price');

        $total_amount = $request->total_amount ?? ($intention_price * count($request->intentions));
        $intention_register = IntentionRegister::create([
            'register_by' => $session->user_id,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'total_amount' => $total_amount,
        ]);

        // Intentions
        $intentions = [];
        foreach ($request->intentions as $intention) {
            $intentions[] = [
                'intention_register_id' => $intention_register->id,
                'mass_date' => $intention['mass_date'],
                'mass_schedule_id' => $intention['mass_schedule_id'],
                'intention_type_id' => $intention['intention_type_id'],
                'person_name' => $intention['person_name'],
                'amount' => $intention_price,
            ];
        }
        Intention::insert($intentions);

        // Payment Method
        $last_receipt = ReceiptNumberSequence::where('receipt_type_id', $request->receipt_type_id)
            ->first();
        $current_receipt_number = $last_receipt->last_receipt_number + 1;

        PaymentReceipt::create([
            'intention_register_id' => $intention_register->id,
            'amount_charged' => $request->amount_charged,
            'amount_paid' => $total_amount,
            'receipt_type_id' => $request->receipt_type_id,
            'receipt_number' => $last_receipt->prefix . $current_receipt_number,
            'payment_method_id' => $request->payment_method_id,
        ]);

        $last_receipt->update([
            'last_receipt_number' => $current_receipt_number,
        ]);

        return "Registro creado con éxito";
    }

    public static function update(Request $request, int $intention_register_id)
    {
        $intention_register = IntentionRegister::findOrFail($intention_register_id);

        $session = SessionManagerService::get();
        $user = User::where('id', $session->user_id)->first();

        IntentionRegisterHelper::validateUpdateRequest($request, $user);

        $intention_register->update([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'total_amount' => $request->total_amount,
        ]);

        // Update Payment Method
        $payment_receipt = PaymentReceipt::where('intention_register_id', $intention_register->id)
            ->first();
        $payment_receipt->update([
            'amount_charged' => $request->amount_charged,
            'amount_paid' => $request->total_amount,
            'receipt_type_id' => $request->receipt_type_id,
            'payment_method_id' => $request->payment_method_id,
        ]);

        return "Registro actualizado con éxito";
    }

    public static function updateIntention(Request $request, int $intention_id)
    {
        $intention = Intention::findOrFail($intention_id);

        $session = SessionManagerService::get();
        $user = User::where('id', $session->user_id)->first();

        IntentionRegisterHelper::validateUpdateIntentionRequest($request, $user);

        $intention->update([
            'mass_date' => $request->mass_date,
            'mass_schedule_id' => $request->mass_schedule_id,
            'intention_type_id' => $request->intention_type_id,
            'person_name' => $request->person_name,
        ]);

        return "Intención actualizada con éxito";
    }

    public static function deleteIntention(int $intention_id)
    {
        $intention = Intention::findOrFail($intention_id);

        $session = SessionManagerService::get();
        $user = User::where('id', $session->user_id)->first();

        if (!$user->hasRole(RoleEnum::ADMIN)) {
            throw new Exception("Una intención solo puede ser eliminada por el administador.");
        }

        $intention->delete();
        return "Intención eliminada con éxito";
    }

    public static function delete(int $intention_register_id)
    {
        $intention_register = IntentionRegister::findOrFail($intention_register_id);

        $session = SessionManagerService::get();
        $user = User::where('id', $session->user_id)->first();

        if (!$user->hasRole(RoleEnum::ADMIN)) {
            throw new Exception("Un registro de intenciones solo puede ser eliminado por el administador.");
        }

        $intention_register->delete();
        return "Registro eliminado con éxito";
    }
}
