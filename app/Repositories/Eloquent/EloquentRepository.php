<?php


namespace App\Repositories\Eloquent;


use App\Repositories\NullDefaultSupportTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function add($attributes)
    {
        $model = $this->model->replicate();
        $model->fill($attributes);
        return $this->saveIfValid($model);
    }

    public function update($id, $attributes)
    {
        $model = $this->find($id);
        $model->fill($attributes);
        return $this->saveIfValid($model);
    }

    public function paginate($query = [])
    {
        $sort = $query['sort'] ?? null;
        $perPage = $query['per_page'] ?? null;
        if (isset($sort) && Schema::hasColumn($this->model->getTable(), $sort)) {
            return $this->model->orderBy($sort)->paginate($perPage);
        }
        return $this->model->paginate($perPage);
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
