<?php

/** @noinspection PhpUndefinedMethodInspection */

namespace Tests\Unit;

use App\Models\ServiceCategory;
use App\Repositories\ServiceCategoryRepository;
use Database\Factories\ServiceCategoryFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    private ServiceCategoryRepository $serviceCategoryRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceCategoryRepository = App::make(ServiceCategoryRepository::class);
    }

    /** @test */
    public function allByService_CategoryWithItems_CategoryWithItemsReturned(): void
    {
        /** @var ServiceCategoryFactory $ServiceCategoryFactory */
        $ServiceCategoryFactory = ServiceCategory::factory(['service_id' => 0]);
        $ServiceCategoryFactory
            ->hasServiceCategoryItems(3)
            ->create();
        $category = $this->serviceCategoryRepository->allByService(0)[0];
        $this->assertCount(3, $category->serviceCategoryItems);
    }
}
