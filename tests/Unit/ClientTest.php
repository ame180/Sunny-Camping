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
        $client->departureDate = $client->arrivalDate;
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function getStayPrice_ClientWithStayPriceOf216_216Returned(): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $client = Client::factory()
            ->hasClientItems(3, [
                'count' => 2,
                'price' => 10,
            ])
            ->create();
        $client->arrivalDate = '2021-01-01';
        $client->departureDate = '2021-01-05';
        $client->discount = 10;

        $this->assertEquals(216, $client->price);
    }

    /** @test */
    public function fillModel_ValidClient_AllCustomPropertiesAccessible(): void
    {
        $client = Client::factory()->make();
        $arr = $client->toArray();
        $this->assertArrayHasKey('pricePerDay', $arr);
        $this->assertArrayHasKey('price', $arr);
        $this->assertArrayHasKey('days', $arr);
    }
}
