<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptNumberSequence extends Model
{
    protected $table = 'receipt_number_sequence';

    protected $fillable = [
        'receipt_type_id',
        'prefix',
        'last_receipt_number',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function receiptType()
    {
        return $this->belongsTo(ReceiptType::class, 'receipt_type_id');
    }
}
