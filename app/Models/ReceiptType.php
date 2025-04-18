<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptType extends Model
{
    protected $table = 'receipt_type';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
