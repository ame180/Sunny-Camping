<?php


namespace App\Repositories;

interface ClientRepositoryInterface
{
    /**
     * @param $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    public function paginate($query = []);

    public function find(int $id);

    public function add($attributes);

    public function delete($id);

    public function settle(int $id, int $amount);
}
