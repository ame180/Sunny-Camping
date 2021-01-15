<?php


namespace App\Repositories;

use Illuminate\Http\Request;

interface ClientRepositoryInterface
{
    public function all($columns);

    public function paginate($query = []);

    public function add($attributes);

    public function delete($id);
}
