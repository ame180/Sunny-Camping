<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    /**
     * @param $columns
     * @return mixed
     */
    public function all(array $columns = ['*']): Collection;

    public function paginate(array $query = []): LengthAwarePaginator;

    public function find(int $id): Model;

    public function add(array $attributes): bool;

    public function update(int $id, array $attributes): bool;

    public function delete(int $id): void;

    public function settle(int $id, int $amount): bool;
}
