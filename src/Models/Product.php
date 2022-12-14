<?php

namespace Kanagama\EloquentExpansion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
