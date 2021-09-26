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
        return $this->model->find($id);
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }

    public function save(Model $model): void
    {
        $model->save();
    }

    public function paginate(int $perPage = null, string $sort = null): LengthAwarePaginator
    {
        if (isset($sort) && Schema::hasColumn($this->model->getTable(), $sort)) {
            return $this->model->orderBy($sort)->paginate($perPage);
        }

        return $this->model->paginate($perPage);
    }
}
