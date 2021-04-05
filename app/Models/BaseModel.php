<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function toArray(): array
    {
        $array = [];
        foreach (parent::toArray() as $key => $value) {
            $array[Str::camel($key)] = $value;
        }

        return $array;
    }

    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations) || method_exists($this, $key)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(Str::snake($key));
        }
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function __isset($key): bool
    {
        return parent::__isset($key) || parent::__isset(Str::snake($key));
    }

    public function __unset($key)
    {
        parent::__unset($key);
        parent::__unset(Str::snake($key));
    }
}
