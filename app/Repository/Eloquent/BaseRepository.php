<?php


namespace App\Repository\Eloquent;


use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $notNullable = [];
    protected $defaultValues = [];

    protected function setNotNullableToDefault(Model $model)
    {
        foreach ($model->toArray() as $attribute => $value) {
            if (isset($model->$attribute)) continue;
            if (!in_array($attribute, $this->notNullable)) continue;
            if (!in_array($attribute, $this->defaultValues)) unset($model->$attribute);
            // TODO: Throw an exception above instead
            $model->$attribute = $this->defaultValues[$attribute];
        }
        return $model;
    }
}
