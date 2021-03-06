<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface {
    public function allByService(int $serviceId): Collection;
}
