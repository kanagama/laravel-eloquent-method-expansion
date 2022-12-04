<?php

namespace Kanagama\EloquentExpansion\Models;

use Kanagama\EloquentExpansion\Models\Traits\FieldViewFlgBehavior;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author k-nagama <k-nagama0632@gmail.com>
 */
class Area extends Model
{
    use HasFactory;
    use FieldViewFlgBehavior;

    protected $fillable = [
        'name',
        'view_flg',
        'created_at',
        'updated_at',
    ];
}
