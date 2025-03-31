<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class SystemConfiguration extends Model
{
    protected $table = 'system_configuration';

    protected $fillable = [
        'key',
        'name',
        'type',
        'value',
    ];

    public function scopeByKey($query, $key, $value)
    {
        $result = $query->where($key, $value)->first();

        if (!$result) {
            throw new Exception('Parámetro no encontrado');
        }

        return $result;
    }
}
