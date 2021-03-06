<?php


namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Models\Client;
use CategoryRepositoryInterface;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Category();
    }

    public function allWithItems(int $serviceId): array
    {
        $this->all()->where;
    }
}
