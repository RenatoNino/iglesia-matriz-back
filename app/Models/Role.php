<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'role';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'role_option');
    }

    public function scopeByKey($query, $key, $value)
    {
        $result = $query->where($key, $value)->first();

        if (!$result) {
            throw new Exception('Rol no encontrado');
        }

        return $result;
    }
}
