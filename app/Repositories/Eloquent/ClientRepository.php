<?php


namespace App\Repositories\Eloquent;


use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use DateTime;
use Illuminate\Http\Request;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    protected $prices = ['adult' => 18, 'child' => 14, 'electricity' => 10, 'small_place' => 4, 'big_place' => 6];
    // TODO: Get $prices from DB
    protected $discounts = [0, 5, 10];
    // TODO: Get $discounts from DB

    protected $notNullable = ['arrival_date', 'departure_date', 'adults', 'children', 'electricity', 'small_places',
        'big_places', 'discount'];
    protected $defaultValues = [
        'adults' => 0,
        'children' => 0,
        'electricity' => 0,
        'small_places' => 0,
        'big_places' => 0,
        'discount' => 0
    ];

    public function add(Request $request)
    {
        // TODO: Change validateRequest to validateModel / validate
        if (!$this->validateRequest($request)) return;
        $client = new Client($request->all());
        $client = $this->setNotNullableToDefault($client, $this->notNullable, $this->defaultValues);
        $client->save();
    }

    public function validateRequest(Request $request)
    {
        if ($request->method() != 'PUT') return false;
        if (empty($request->first_name) && empty($request->second_name)) return false;
        if (!isset($request->arrival_date) || !isset($request->departure_date)) return false;
        if ($request->adults == 0 && $request->children == 0) return false;
        if (!in_array($request->discount, $this->discounts)) return false;
        return true;
    }

    public function all()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $client->price = $this->getStayPrice($client);
        }
        return $clients;
    }

    public function getStayPrice(Client $client)
    {
        $arrival = new DateTime($client->arrival_date);
        $departure = new DateTime($client->departure_date);
        $days = $departure->diff($arrival)->format("%a");
        $price = $days * ($this->prices['adult'] * $client->adults + $this->prices['child'] * $client->children
                + $this->prices['small_place'] * $client->small_places + $this->prices['big_place'] * $client->big_places
                + $client->electricity) * (1 - $client->discount / 100);
        return (int)$price;
    }
}
