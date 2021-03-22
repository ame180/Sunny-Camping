<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientItem;
use Illuminate\Database\Eloquent\Model;

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

        $model->fill($attributes);
        $model->arrival_date = $attributes['arrivalDate'];
        $model->departure_date = $attributes['departureDate'];

        if (!isset($model->paid) || $model->paid <= $model->price) {
            $model->status = 'unsettled';
        } else {
            $model->status = 'settled';
        }

        if ($this->saveIfValid($model)) {
            $model->clientItems()->delete();

            foreach ($attributes['clientItems'] as $clientItemRaw) {
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
        $model->arrival_date = $attributes['arrivalDate'];
        $model->departure_date = $attributes['departureDate'];

        if ($this->saveIfValid($model)) {
            foreach ($attributes['clientItems'] as $clientItemRaw) {
                $clientItem = new ClientItem();
                $clientItem->fill($clientItemRaw);
                $clientItem->id = null;
                $model->clientItems()->save($clientItem);
            }

            return true;
        }

        return false;
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
        if ($model->paid >= $model->price) {
            $model->status = 'settled';
        } else {
            $model->status = 'unsettled';
        }
        $model->save();

        return true;
    }
}
