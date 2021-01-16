<?php


namespace App\Repositories;

use Illuminate\Http\Request;

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
