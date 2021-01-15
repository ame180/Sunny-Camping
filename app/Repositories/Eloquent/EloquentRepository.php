<?php


namespace App\Repositories\Eloquent;


use App\Repositories\NullDefaultSupportTrait;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
{
    use NullDefaultSupportTrait;

    /** @var Model */
    protected $model;
    protected $notNullable = [];
    protected $defaultValues = [];

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function add($attributes)
    {
        $model = $this->model;
        $model->fill($attributes);
        return $this->saveIfValid($model);
    }

    public function update($id, $attributes)
    {
        $client = $this->find($id);
        $client->fill($attributes);
        return $this->saveIfValid($client);
    }

    public function paginate()
    {
        return $this->model->paginate();
    }

    protected function saveIfValid(Model $model)
    {
        $model = $this->setNotNullableToDefault($model, $this->notNullable, $this->defaultValues);
        if (!$this->validateModel($model)) return false;
        $model->save();
        return true;
    }

    public function validateModel(Model $model)
    {
        return true;
    }
}
