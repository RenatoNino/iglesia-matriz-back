<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MassSchedule extends Model
{
    use SoftDeletes;
    protected $table = 'mass_schedule';
    protected $fillable = [
        'day_of_week',
        'start_time',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getStartTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }
    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }
}
