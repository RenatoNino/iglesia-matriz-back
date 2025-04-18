<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntentionType extends Model
{
    use SoftDeletes;

    protected $table = 'intention_type';

    protected $fillable = [
        'id',
        'name',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
