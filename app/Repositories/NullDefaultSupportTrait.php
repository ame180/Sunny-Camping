<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

trait NullDefaultSupportTrait
{
    protected function setNotNullableToDefault(Model $model, array $notNullable = [], array $defaultValues = []): Model
    {
        foreach ($model->toArray() as $attribute => $value) {
            if (isset($model->$attribute)) continue;
            if (!in_array($attribute, $notNullable)) continue;
            if (!in_array($attribute, $defaultValues)) unset($model->$attribute);
            $model->$attribute = $defaultValues[$attribute];
        }
        return $model;
    }
}
