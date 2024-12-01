<?php

namespace Kanagama\EloquentExpansion\Tests\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $prefecture_id
 * @property string $name
 * @property Carbon|CarbonImmutable $created_at
 * @property Carbon|CarbonImmutable $updated_at
 * @property-read BelongsTo $prefecture
 *
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class City extends Model
{

    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'prefecture_id',
        'name',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id');
    }
}
