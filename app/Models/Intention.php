<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intention extends Model
{
    use SoftDeletes;

    protected $table = 'intention';

    protected $fillable = [
        'intention_register_id',
        'mass_date',
        'mass_schedule_id',
        'intention_type_id',
        'person_name',
        'amount',
    ];

    // Casting
    public function getMassDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    public function setMassDateAttribute($value)
    {
        $this->attributes['mass_date'] = \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    // Relationships
    public function intentionRegister()
    {
        return $this->belongsTo(IntentionRegister::class);
    }
    public function massSchedule()
    {
        return $this->belongsTo(MassSchedule::class);
    }

    public function intentionType()
    {
        return $this->belongsTo(IntentionType::class);
    }
}
