<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $table = 'person';

    protected $fillable = [
        'document_type',
        'document_number',
        'names',
        'phone',
        'email',
        'sex',
        'birth_date',
        'native_language',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function scopeByKey($query, $key, $value)
    {
        $result = $query->where($key, $value)->first();

        if (!$result) {
            throw new Exception('Persona no encontrada');
        }

        return $result;
    }
}
