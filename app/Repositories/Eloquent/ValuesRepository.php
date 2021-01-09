<?php

namespace App\Repositories\Eloquent;

use App\Models\Value;
use App\Repositories\ValuesRepositoryInterface;

class ValuesRepository extends EloquentRepository implements ValuesRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Value;
    }

    public function getByType($type)
    {
        return $this->model->where('type', '=', $type)->get();
    }
}
