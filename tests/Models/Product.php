<?php

namespace Kanagama\EloquentExpansion\Tests\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|CarbonImmutable $sale_date_start
 * @property Carbon|CarbonImmutable $sale_date_end
 * @property Carbon|CarbonImmutable $date
 * @property Carbon|CarbonImmutable $created_at
 * @property Carbon|CarbonImmutable $updated_at
 *
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'discontinued',
        'sale_date_start',
        'sale_date_end',
        'date',
        'created_at',
        'updated_at',
    ];
}
