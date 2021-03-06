<?php


namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Category();
    }

    public function allByService(int $serviceId): Collection
    {
        $categories = $this->model->where('service_id', $serviceId)->get();
        foreach ($categories as $category) {
            $this->fillModel($category);
        }
        return $categories;
    }

    public function fillModel(Model $model): void {
        $model->categoryItems = $this->getCategoryItems($model);
    }

    private function getCategoryItems(Model $model): Collection
    {
        return $model->categoryItems;
    }
}
