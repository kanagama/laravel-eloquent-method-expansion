<?php

namespace Kanagama\EloquentExpansion\Tests\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Kanagama\EloquentExpansion\Tests\Models\Traits\FieldViewFlgBehavior;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int|null $view_flg
 * @property Carbon|CarbonImmutable $created_at
 * @property Carbon|CarbonImmutable $updated_at
 *
 * @author k-nagama <k-nagama0632@gmail.com>
 */
class Area extends Model
{
    use HasFactory;
    use FieldViewFlgBehavior;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'view_flg',
        'created_at',
        'updated_at',
    ];
}
