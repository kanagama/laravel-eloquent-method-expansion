<?php

namespace Kanagama\EloquentExpansion\Tests\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|CarbonImmutable $created_at
 * @property Carbon|CarbonImmutable $updated_at
 * @property HasMany $cities
 *
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class Prefecture extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasMany
     * @author k-nagama <k-nagama@se-ec.co.jp>
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'prefecture_id');
    }
}
