<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientItem;
use Illuminate\Database\Eloquent\Model;

class ClientRepository extends BaseRepository
{
    private array $discounts;

    public function __construct()
    {
        $this->model = new Client;
        $this->discounts = config('constants.discounts');
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->find($id);

        $model->fill($attributes);

        if ($this->saveIfValid($model)) {
            $model->clientItems()->delete();

            foreach ($attributes['client_items'] as $clientItemRaw) {
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
        if (strtotime($model->arrival_date) && strtotime($model->departure_date)
            && strtotime($model->arrival_date) >= strtotime($model->departure_date)) {
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

        if ($this->saveIfValid($model)) {
            foreach ($attributes['client_items'] as $clientItemRaw) {
                $clientItem = new ClientItem();
                $clientItem->fill($clientItemRaw);
                $clientItem->id = null;
                $model->clientItems()->save($clientItem);
            }

            return true;
        }

        return false;
    }

    public function settle(int $id, int $settlement, int $climateSettlement): bool
    {
        if ($settlement <= 0 && $climateSettlement <= 0) {
            return false;
        }

        $model = $this->find($id);
        if (!isset($model)) {
            return false;
        }

        $model->paid += $settlement;
        $model->climate_paid += $climateSettlement;

        if ($model->paid + $model->climate_paid >= $model->price + $model->climate_price) {
            $model->status = 'settled';
        } else {
            $model->status = 'unsettled';
        }
        $model->save();

        return true;
    }
}
