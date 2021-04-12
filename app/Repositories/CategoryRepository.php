<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Category();
    }

    public function allByService(int $serviceId): Collection
    {
        $categories = $this->model->with('categoryItems')->where('service_id', $serviceId)->get();

        return $categories;
    }
}
