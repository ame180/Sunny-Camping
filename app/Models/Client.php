<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends BaseModel
{
    use HasFactory;

    protected $guarded = ['price', 'price_per_day', 'days'];

    protected $appends = ['price', 'price_per_day', 'days'];

    public function getPriceAttribute()
    {
        $days = $this->days;
        if ($days == 0) {
            return 0;
        }

        return floor($days * $this->pricePerDay * (100 - $this->discount) / 100);
    }

    public function getPricePerDayAttribute()
    {
        $clientItems = $this->clientItems;
        $price = 0;
        foreach ($clientItems as $clientItem) {
            $price += $clientItem->price * $clientItem->count;
        }

        return $price;
    }

    public function getDaysAttribute()
    {
        if (!strtotime($this->arrival_date) || !strtotime($this->departure_date)) {
            return 0;
        }

        $arrival = new Carbon($this->arrival_date);
        $departure = new Carbon($this->departure_date);

        return $departure->diff($arrival)->format('%a');
    }

    public function clientItems()
    {
        return $this->hasMany(ClientItem::class);
    }
}
