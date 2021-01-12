<?php


namespace App\Repositories;

interface ClientRepositoryInterface
{
    public function all($columns);

    public function add($attributes);

    public function delete($id);
}
