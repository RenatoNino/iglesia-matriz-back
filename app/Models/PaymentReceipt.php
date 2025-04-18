<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    protected $table = 'payment_receipt';

    protected $fillable = [
        'intention_register_id',
        'amount_charged',
        'amount_paid',
        'receipt_type_id',
        'receipt_number',
        'payment_method_id',
    ];

    // Relationships
    public function intentionRegister()
    {
        return $this->belongsTo(IntentionRegister::class);
    }
    public function receiptType()
    {
        return $this->belongsTo(ReceiptType::class);
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
