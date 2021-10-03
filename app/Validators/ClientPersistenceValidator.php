<?php

namespace App\Validators;

use App\Models\Client;
use Illuminate\Support\Facades\Config;

class ClientPersistenceValidator
{
    public function isValid(Client $client): bool
    {
        if (empty($client->name)) {
            return false;
        }

        if (strtotime($client->arrival_date) && strtotime($client->departure_date)
            && strtotime($client->arrival_date) >= strtotime($client->departure_date)) {
            return false;
        }

        if (!in_array($client->discount, Config::get('constants.discounts'))) {
            return false;
        }

        return true;
    }
}
