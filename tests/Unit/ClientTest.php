<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ClientTest extends TestCase
{
    private ClientRepository $clientRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->clientRepository = App::make(ClientRepository::class);
    }

    /** @test */
    public function validateModel_ValidClient_TrueReturned(): void
    {
        $client = Client::factory()->make();
        $this->assertTrue($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function validateModel_ClientWithoutName_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->name = '';
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function validateModel_ClientWithDepartureBeforeOrAtArrival_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->departure_date = $client->arrival_date;
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function getStayPrice_ClientWithStayPriceOf216_216Returned(): void
    {
        /** @var Client $client @noinspection PhpUndefinedMethodInspection */
        $client = Client::factory()
            ->hasClientItems(3, [
                'count' => 2,
                'price' => 10,
            ])
            ->create();
        $client->arrival_date = '2021-01-01';
        $client->departure_date = '2021-01-05';
        $client->discount = 10;

        $this->assertEquals(216, $client->price);
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
