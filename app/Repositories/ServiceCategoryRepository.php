<?php

namespace App\Repositories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;

class ServiceCategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(ServiceCategory::class);
    }

    public function allByService(int $serviceId): Collection
    {
        $serviceCategories = $this->model->with('serviceCategoryItems')->where('service_id', $serviceId)->get();

        return $serviceCategories;
    }
}
