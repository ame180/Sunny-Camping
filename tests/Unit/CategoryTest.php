<?php

/** @noinspection PhpUndefinedMethodInspection */

namespace Tests\Unit;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    private CategoryRepository $categoryRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = App::make(CategoryRepository::class);
    }

    /** @test */
    public function allByService_CategoryWithItems_CategoryWithItemsReturned(): void
    {
        Category::factory(['service_id' => 0])
            ->hasCategoryItems(3)
            ->create();
        $category = $this->categoryRepository->allByService(0)[0];
        $this->assertCount(3, $category->categoryItems);
    }
}
