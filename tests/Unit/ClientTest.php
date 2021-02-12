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
    public function validateModel_ValidClients_TrueReturned(): void
    {
        $clients = Client::factory()->count(5)->make();
        foreach ($clients as $client) {
            var_dump($client);
            $this->assertTrue($this->clientRepository->validateModel($client));
        }
    }

    /** @test */
    public function validateModel_InvalidClients_FalseReturned(): void
    {
        $clients = Client::factory()->count(6)->make();

        $clients[0]->firstName = "";
        $clients[0]->lastName = "";

        $clients[1]->arrivalDate = "";

        $clients[2]->departureDate = $clients[2]->arrivalDate;

        $clients[3]->adults = 0;
        $clients[3]->children = 0;

        $clients[4]->small_places = -1;

        $clients[5]->departureDate = "test";

        foreach ($clients as $client) {
            var_dump($client);
            $this->assertFalse($this->clientRepository->validateModel($client));
        }
    }

    /** @test */
    public function getStayPrice(): void
    {
        $client = Client::factory()->make([
            "arrival_date" => "2021-01-01",
            "departure_date" => "2021-01-03",
            "adults" => 3,
            "children" => 2,
            "electricity" => 1,
            "small_places" => 3,
            "big_places" => 2,
            "discount" => 5
        ]);
        $this->assertEquals(220, $this->clientRepository->getStayPrice($client));
    }
}
