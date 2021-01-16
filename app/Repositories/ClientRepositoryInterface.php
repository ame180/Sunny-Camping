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

    public function find($id);

    public function add($attributes);

    public function delete($id);
}
