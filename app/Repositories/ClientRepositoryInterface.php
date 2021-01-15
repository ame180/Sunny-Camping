<?php


namespace App\Repositories;

interface ClientRepositoryInterface
{
    /**
     * @param $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    public function add($attributes);

    public function delete($id);
}
