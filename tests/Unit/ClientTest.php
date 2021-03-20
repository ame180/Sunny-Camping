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
    public function validateModel_ClientWithNoFirstAndLastName_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->firstName = '';
        $client->lastName = '';
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function validateModel_ClientWithEmptyArrivalOrDepartureDate_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->arrivalDate = '';
        $this->assertFalse($this->clientRepository->validateModel($client));

        $client = Client::factory()->make();
        $client->departureDate = '';
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
    public function validateModel_ClientWithNoPeople_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->adults = 0;
        $client->children = 0;
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function validateModel_ClientWithNegativeValues_FalseReturned()
    {
        $client = Client::factory()->make();
        $client->electricity = -1;
        $this->assertFalse($this->clientRepository->validateModel($client));

        $client = Client::factory()->make();
        $client->bigPlaces = -10;
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function getStayPrice_ClientWithStayPriceOf220_220Returned(): void
    {
        $client = Client::factory()->make([
            'arrival_date' => '2021-01-01',
            'departure_date' => '2021-01-03',
            'adults' => 3,
            'children' => 2,
            'electricity' => 1,
            'small_places' => 3,
            'big_places' => 2,
            'discount' => 5,
        ]);
        $this->assertEquals(220, $this->clientRepository->getStayPrice($client));
    }
}
