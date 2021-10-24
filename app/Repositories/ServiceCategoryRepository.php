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

    public function findWithCategoryItemsByFilters(array $filters = []): Collection
    {
        $query = $this->model->with('serviceCategoryItems');

        if (isset($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        return $query->get();
    }
}
