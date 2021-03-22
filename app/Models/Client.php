<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JetBrains\PhpStorm\Pure;

class Client extends BaseModel
{
    use HasFactory;

    protected $guarded = ['price', 'price_per_day', 'days'];

    protected $appends = ['price', 'price_per_day', 'days'];

    public function getPriceAttribute(): float
    {
        if ($this->days === 0) {
            return 0;
        }

        return floor($this->days * $this->pricePerDay * (100 - $this->discount) / 100);
    }

    public function getPricePerDayAttribute(): float
    {
        $clientItems = $this->clientItems;
        $price = 0;
        foreach ($clientItems as $clientItem) {
            $price += $clientItem->price * $clientItem->count;
        }

        return $price;
    }

    public function getDaysAttribute(): int
    {
        if (!strtotime($this->arrival_date) || !strtotime($this->departure_date)) {
            return 0;
        }

        $arrivalDate = new Carbon($this->arrival_date);
        $departureDate = new Carbon($this->departure_date);

        return $departureDate->diff($arrivalDate)->format('%a');
    }

    public function clientItems(): HasMany
    {
        return $this->hasMany(ClientItem::class);
    }
}
