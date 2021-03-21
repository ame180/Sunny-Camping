<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientItem;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ClientRepository extends BaseRepository
{
    protected array $prices = ['adult' => 18, 'child' => 14, 'electricity' => 10, 'smallPlaces' => 4, 'bigPlaces' => 6];
    protected array $discounts;

    protected array $notNullable = ['discount', 'paid', 'status'];
    protected array $defaultValues = [
        'discount' => 0,
        'paid' => 0,
        'status' => 'unsettled',
    ];

    public function __construct()
    {
        $this->model = new Client;
        $this->discounts = config('constants.discounts');
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->find($id);

        $clientItemsRaw = $attributes['clientItems'];
        unset($attributes['clientItems']);

        $model->fill($attributes);

        if (!isset($model->paid) || $model->paid <= $this->getStayPrice($model)) {
            $model->status = 'unsettled';
        } else {
            $model->status = 'settled';
        }

        if ($this->saveIfValid($model)) {
            $clientItems = [];

            foreach ($clientItemsRaw as $clientItemRaw) {
                $clientItem = ClientItem::find($clientItemRaw['id']) ?? new ClientItem();
                $clientItem->fill($clientItemRaw);
                $model->clientItems()->save($clientItem);
            }

            return true;
        }

        return false;
    }

    public function find(int $id): Model | null
    {
        if ($id <= 0) {
            return null;
        }

        return $this->model->with('clientItems')->find($id);
    }

    public function validateModel(Model $model): bool
    {
        if (empty($model->name)) {
            return false;
        }
        if (strtotime($model->arrivalDate) && strtotime($model->departureDate)
            && strtotime($model->arrivalDate) >= strtotime($model->departureDate)) {
            return false;
        }
        if (!in_array($model->discount, $this->discounts)) {
            return false;
        }

        return true;
    }

    public function add(array $attributes): bool
    {
        $model = $this->model->replicate();
        $model->fill($attributes);

        $clientItemsRaw = $model->client_items;
        unset($model->client_items);

        if ($this->saveIfValid($model)) {
            $clientItems = [];

            foreach ($clientItemsRaw as $clientItemRaw) {
                $clientItem = new ClientItem();
                $clientItem->fill($clientItemRaw);
                $clientItem->id = null;
                $model->clientItems()->save($clientItem);
            }

            return true;
        }

        return false;
    }

    public function all(array $columns = ['*']): Collection
    {
        $models = parent::all($columns);
        foreach ($models as $model) {
            $this->fillModel($model);
        }

        return $models;
    }

    public function paginate(array $query = []): LengthAwarePaginator
    {
        $paginator = parent::paginate($query);
        foreach ($paginator->items() as $model) {
            $this->fillModel($model);
        }

        return $paginator;
    }

    public function fillModel(Model $model): void
    {
        $model->pricePerDay = $this->getPricePerDay($model);
        $model->price = $this->getStayPrice($model);
        $model->days = $this->getDays($model);
    }

    public function getClientItems(Model $model): Collection
    {
        return $model->clientItems;
    }

    public function getPricePerDay(Model $model): float
    {
        $clientItems = $this->getClientItems($model);
        $price = 0;
        foreach ($clientItems as $clientItem) {
            $price += $clientItem->price * $clientItem->count;
        }

        return $price;
    }

    public function getDays(Model $model): int
    {
        if (!strtotime($model->arrivalDate) || !strtotime($model->departureDate)) {
            return 0;
        }
        $arrival = new DateTime($model->arrivalDate);
        $departure = new DateTime($model->departureDate);

        return $departure->diff($arrival)->format('%a');
    }

    public function getStayPrice(Model $model): float
    {
        $days = $this->getDays($model);
        if ($days == 0) {
            return 0;
        }

        return floor($days * $this->getPricePerDay($model) * (100 - $model->discount) / 100);
    }

    public function settle(int $id, int $amount): bool
    {
        if ($amount <= 0) {
            return false;
        }
        $model = $this->find($id);
        if (!isset($model)) {
            return false;
        }
        $model->paid += $amount;
        if ($model->paid >= $this->getStayPrice($model)) {
            $model->status = 'settled';
        } else {
            $model->status = 'unsettled';
        }
        $model->save();

        return true;
    }
}
