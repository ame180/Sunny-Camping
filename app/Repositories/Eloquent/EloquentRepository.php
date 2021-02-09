<?php


namespace App\Repositories\Eloquent;


use App\Repositories\NullDefaultSupportTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

abstract class EloquentRepository
{
    use NullDefaultSupportTrait;

    protected Model $model;
    protected array $notNullable = [];
    protected array $defaultValues = [];

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /** @noinspection PhpUndefinedMethodInspection */
    public function find(int $id): Model
    {
        return $this->model->find($id);
    }

    public function delete(int $id): void
    {
        $this->model->destroy($id);
    }

    public function add(array $attributes): bool
    {
        $model = $this->model->replicate();
        $model->fill($attributes);
        return $this->saveIfValid($model);
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->find($id);
        $model->fill($attributes);
        return $this->saveIfValid($model);
    }

    /** @noinspection PhpUndefinedMethodInspection */
    public function paginate(array $query = []): LengthAwarePaginator
    {
        $sort = $query['sort'] ?? null;
        $perPage = $query['per_page'] ?? null;
        if (isset($sort) && Schema::hasColumn($this->model->getTable(), $sort)) {
            return $this->model->orderBy($sort)->paginate($perPage);
        }
        return $this->model->paginate($perPage);
    }

    protected function saveIfValid(Model $model): bool
    {
        $model = $this->setNotNullableToDefault($model, $this->notNullable, $this->defaultValues);
        if (!$this->validateModel($model)) return false;
        $model->save();
        return true;
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateModel(Model $model): bool
    {
        return true;
    }
}
