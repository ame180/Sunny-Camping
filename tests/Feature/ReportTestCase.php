<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientItem;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

abstract class ReportTestCase extends TestCase
{
    use RefreshDatabase;

    protected const REPORT_YEAR = 2025;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    protected function createSettledClient(string $arrivalDate, string $departureDate, array $attributes = []): Client
    {
        return Client::factory()->create(array_merge([
            'arrival_date' => $arrivalDate,
            'departure_date' => $departureDate,
            'discount' => 0,
            'status' => Client::STATUS_SETTLED,
        ], $attributes));
    }

    protected function createClientItem(Client $client, ?ServiceCategory $category, float $price, int $count = 1, array $attributes = []): ClientItem
    {
        return ClientItem::factory()->create(array_merge([
            'client_id' => $client->id,
            'service_category_id' => $category->id ?? 0,
            'price' => $price,
            'count' => $count,
        ], $attributes));
    }

    protected function createCategory(string $name): ServiceCategory
    {
        return ServiceCategory::factory()->create(['name' => $name]);
    }

    protected function getReport(string $url): TestResponse
    {
        return $this->actingAs($this->user)->getJson($url);
    }

    protected function seriesValuesByKey(TestResponse $response): array
    {
        return collect($response->json('series'))->pluck('values', 'key')->all();
    }

    protected function monthValues(array $amountsByMonth): array
    {
        $values = array_fill(0, 12, 0);
        foreach ($amountsByMonth as $month => $amount) {
            $values[$month - 1] = $amount;
        }

        return $values;
    }
}
