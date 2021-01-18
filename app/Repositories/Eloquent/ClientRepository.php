<?php


namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use DateTime;

class ClientRepository extends EloquentRepository implements ClientRepositoryInterface
{
    protected $prices = ['adult' => 18, 'child' => 14, 'electricity' => 10, 'small_place' => 4, 'big_place' => 6];
    protected $discounts = [0, 5, 10];

    protected $model;
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

    public function __construct()
    {
        $this->model = new Client;
    }

    public function validateModel(Model $model)
    {
        if (empty($model->first_name) && empty($model->last_name)) return false;
        if (!isset($model->arrival_date) || !isset($model->departure_date)) return false;
        if (strtotime($model->arrival_date) >= strtotime($model->departure_date)) return false;
        if ($model->adults == 0 && $model->children == 0) return false;
        if (!in_array($model->discount, $this->discounts)) return false;
        if ($model->adults < 0 || $model->children < 0 || $model->electricity < 0 || $model->small_places < 0
            || $model->big_places < 0) return false;
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
        $arrival = new DateTime($client->arrival_date);
        $departure = new DateTime($client->departure_date);
        $days = $departure->diff($arrival)->format("%a");
        $price = $days * ($this->prices['adult'] * $client->adults + $this->prices['child'] * $client->children
                + $this->prices['small_place'] * $client->small_places + $this->prices['big_place'] * $client->big_places
                + $client->electricity) * (1 - $client->discount / 100);
        return (int)$price;
    }
}
