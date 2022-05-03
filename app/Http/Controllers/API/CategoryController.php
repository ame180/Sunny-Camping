<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\ServiceCategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private ServiceCategoryRepository $categoryRepository;

    public function __construct(ServiceCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getMultiple(Request $request)
    {
        return response()->json($this->categoryRepository->findWithCategoryItemsByFilters($request->query->all()));
    }
}
