<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\ClientItem;
use App\Models\ServiceCategory;
use App\Repositories\ClientRepository;
use App\Validators\ClientPersistenceValidator;
use Database\Factories\ServiceCategoryFactory;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ClientTest extends TestCase
{
    private ClientPersistenceValidator $clientPersistenceValidator;

    public function setUp(): void
    {
        parent::setUp();
        $this->clientPersistenceValidator = $this->app->make(ClientPersistenceValidator::class);
    }

    /** @test */
    public function validateModel_ValidClient_TrueReturned(): void
    {
        $client = Client::factory()->make();
        $this->assertTrue($this->clientPersistenceValidator->isValid($client));
    }

    /** @test */
    public function validateModel_ClientWithoutName_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->name = '';
        $this->assertFalse($this->clientPersistenceValidator->isValid($client));
    }

    /** @test */
    public function validateModel_ClientWithDepartureBeforeOrAtArrival_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->departure_date = $client->arrival_date;
        $this->assertFalse($this->clientPersistenceValidator->isValid($client));
    }

    /** @test */
    public function getStayPrice_ClientWithStayPriceOf232_232Returned(): void
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
    public function fillModel_ValidClient_AllCustomPropertiesAccessible(): void
    {
        $client = Client::factory()->make();
        $arr = $client->toArray();
        $this->assertArrayHasKey('price_per_day', $arr);
        $this->assertArrayHasKey('price', $arr);
        $this->assertArrayHasKey('days', $arr);
    }
}
