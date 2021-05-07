<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\ServiceCategoryRepository;

class CategoryController extends Controller
{
    private ServiceCategoryRepository $categoryRepository;

    public function __construct(ServiceCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function allByService($serviceId)
    {
        return $this->categoryRepository->allByService($serviceId)->toJson();
    }
}
