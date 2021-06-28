<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel.
 *
 * @method static Builder|BaseModel newModelQuery()
 * @method static Builder|BaseModel newQuery()
 * @method static Builder|BaseModel query()
 * @mixin Eloquent
 */
class BaseModel extends Model
{
    protected array $defaults = [];

    protected static function booted()
    {
        static::saving(function ($model) {
            foreach ($model->defaults as $attribute => $default) {
                if (!isset($model->$attribute)) {
                    $model->$attribute = $default;
                }
            }
        });
    }
}
