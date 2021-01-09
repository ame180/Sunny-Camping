<?php


namespace App\Repositories\Eloquent;


use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\NullDefaultSupportTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class EloquentRepository
{
    use NullDefaultSupportTrait;

    /** @var Model */
    protected $model;
    protected $notNullable;
    protected $defaultValues;

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
        $client = $this->setNotNullableToDefault($model, $this->notNullable, $this->defaultValues);
        return $this->saveIfValid($client);
    }

    public function update($id, $attributes)
    {
        $client = $this->find($id);
        $client->fill($attributes);
        return $this->saveIfValid($client);
    }

    protected function saveIfValid(Model $model)
    {
        if (!$this->validateModel($model)) return false;
        $model->save();
        return true;
    }

    public abstract function validateModel(Model $model);
}
