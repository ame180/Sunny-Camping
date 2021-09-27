<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\ClientItem;
use App\Models\ServiceCategory;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function validateModelValidClientTrueReturned(): void
    {
        $client = Client::factory()->make();
        $this->assertTrue(Client::validate($client));
    }

    /** @test */
    public function validateModelClientWithoutNameFalseReturned()
    {
        $client = Client::factory()->make();
        $client->name = '';
        $this->assertFalse(Client::validate($client));
    }

    /** @test */
    public function validateModelClientWithDepartureBeforeOrAtArrivalFalseReturned()
    {
        $client = Client::factory()->make();
        $client->departure_date = $client->arrival_date;
        $this->assertFalse(Client::validate($client));
    }

    /** @test */
    public function getStayPriceClientWithStayPriceOf232232Returned(): void
    {
        /** @var Client $client @noinspection PhpUndefinedMethodInspection */
        $serviceCategory = ServiceCategory::factory()->create(['name' => 'Osoby']);
        $clientItem = ClientItem::factory()->create(['count' => 1, 'price' => 20]);
        $clientItem->serviceCategory()->associate($serviceCategory);
        $client = Client::factory()
            ->hasClientItems(2, [
                'count' => 2,
                'price' => 10,
            ])
            ->create();
        $client->clientItems()->save($clientItem);
        $client->arrival_date = '2021-01-01';
        $client->departure_date = '2021-01-05';
        $client->discount = 10;

        $this->assertEquals(232, $client->price);
    }

    /** @test */
    public function fillModelValidClientAllCustomPropertiesAccessible(): void
    {
        $client = Client::factory()->make();
        $arr = $client->toArray();
        $this->assertArrayHasKey('price_per_day', $arr);
        $this->assertArrayHasKey('price', $arr);
        $this->assertArrayHasKey('days', $arr);
    }
}
