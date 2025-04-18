<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntentionRegister extends Model
{
    use SoftDeletes;

    protected $table = 'intention_register';

    protected $fillable = [
        'register_by',
        'client_name',
        'client_phone',
        'total_amount',
    ];

    // Relationships
    public function registerBy()
    {
        return $this->belongsTo(User::class, 'register_by')
            ->select(['user.id', 'user.email', 'person.names'])
            ->join('person', 'user.person_id', '=', 'person.id');
    }
    public function intentions()
    {
        return $this->hasMany(Intention::class);
    }
    public function paymentReceipt()
    {
        return $this->hasOne(PaymentReceipt::class);
    }
}
