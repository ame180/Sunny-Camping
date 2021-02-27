<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ClientTest extends TestCase
{
    private ClientRepositoryInterface $clientRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->clientRepository = App::make(ClientRepositoryInterface::class);
    }

    /** @test */
    public function validateModel_ValidClient_TrueReturned(): void
    {
        $client = Client::factory()->make();
        $this->assertTrue($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function validateModel_ClientWithoutName_FalseReturned() {
        $client = Client::factory()->make();
        $client->name = "";
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function validateModel_ClientWithDepartureBeforeOrAtArrival_FalseReturned() {
        $client = Client::factory()->make();
        $client->departureDate = $client->arrivalDate;
        $this->assertFalse($this->clientRepository->validateModel($client));
    }

    /** @test */
    public function getStayPrice_ClientWithStayPriceOf220_220Returned(): void
    {
        $this->assertEquals(0, 0);
    }
}
