<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

abstract class BaseRepository
{
    protected Model $model;

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function find(int $id): Model | null
    {
        if ($id <= 0) {
            return null;
        }

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
        $this->fillModel($model);

        return $this->saveIfValid($model);
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->find($id);
        $model->fill($attributes);

        return $this->saveIfValid($model);
    }

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
        if (!$this->validateModel($model)) {
            return false;
        }
        $model->save();

        return true;
    }

    public function validateModel(Model $model): bool
    {
        return true;
    }
}
