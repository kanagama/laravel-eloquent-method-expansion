<?php

namespace Kanagama\EloquentExpansion\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder whereViewFlgIsNull()
 *
 * @autor k-nagama <k.nagama0632@gmail.com>
 */
trait FieldViewFlgBehavior
{
    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeWhereViewFlgIsNotNull(Builder $query): Builder
    {
        return $query->whereNotNull('view_flg');
    }
}