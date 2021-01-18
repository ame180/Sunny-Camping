<?php


namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use DateTime;

class ClientRepository extends EloquentRepository implements ClientRepositoryInterface
{
    protected $prices = ['adult' => 18, 'child' => 14, 'electricity' => 10, 'smallPlaces' => 4, 'bigPlaces' => 6];
    protected $discounts;

    protected $model;
    protected $notNullable = ['arrivalDate', 'departureDate', 'adults', 'children', 'electricity', 'smallPlaces',
        'bigPlaces', 'discount'];
    protected $defaultValues = [
        'adults' => 0,
        'children' => 0,
        'electricity' => 0,
        'smallPlaces' => 0,
        'bigPlaces' => 0,
        'discount' => 0
    ];

    public function __construct()
    {
        $this->model = new Client;
        $this->discounts = config('constants.discounts');
    }

    public function validateModel(Model $model)
    {
        if (empty($model->firstName) && empty($model->lastName)) return false;
        if (!isset($model->arrivalDate) || !isset($model->departureDate)) return false;
        if (strtotime($model->arrivalDate) >= strtotime($model->departureDate)) return false;
        if ($model->adults == 0 && $model->children == 0) return false;
        if (!in_array($model->discount, $this->discounts)) return false;
        if ($model->adults < 0 || $model->children < 0 || $model->electricity < 0 || $model->smallPlaces < 0
            || $model->bigPlaces < 0) return false;
        return true;
    }

    public function all($columns = ['*'])
    {
        $clients = parent::all($columns);
        foreach ($clients as $client) {
            $client->price = $this->getStayPrice($client);
        }
        return $clients;
    }

    public function paginate($query = [])
    {
        $paginator = parent::paginate($query);
        foreach ($paginator->items() as $client) {
            $client->price = $this->getStayPrice($client);
        }
        return $paginator;
    }

    public function getStayPrice(Client $client)
    {
        $arrival = new DateTime($client->arrivalDate);
        $departure = new DateTime($client->departureDate);
        $days = $departure->diff($arrival)->format("%a");
        $price = $days * ($this->prices['adult'] * $client->adults + $this->prices['child'] * $client->children
                + $this->prices['smallPlaces'] * $client->smallPlaces + $this->prices['bigPlaces'] * $client->bigPlaces
                + $client->electricity) * (1 - $client->discount / 100);
        return (int)$price;
    }
}
