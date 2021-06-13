<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Client.
 *
 * @property int $id
 * @property string $name
 * @property string|null $arrival_date
 * @property string|null $departure_date
 * @property string|null $comment
 * @property int $discount
 * @property float $paid
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ClientItem[] $clientItems
 * @property-read int|null $client_items_count
 * @property-read int $days
 * @property-read float $price
 * @property-read float $price_per_day
 * @method static ClientFactory factory(...$parameters)
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client whereArrivalDate($value)
 * @method static Builder|Client whereComment($value)
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereDepartureDate($value)
 * @method static Builder|Client whereDiscount($value)
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client whereName($value)
 * @method static Builder|Client wherePaid($value)
 * @method static Builder|Client whereStatus($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @mixin Eloquent
 * @property float $climate_paid
 * @property-read float $climate_price
 * @method static Builder|Client whereClimatePaid($value)
 */
class Client extends BaseModel
{
    use HasFactory;

    const STATUS_SETTLED = 'settled';
    const STATUS_UNSETTLED = 'unsettled';

    protected $guarded = ['price', 'price_per_day', 'days', 'climate_price'];

    protected $appends = ['price', 'price_per_day', 'days', 'climate_price'];

    protected array $defaults = [
        'discount' => 0,
        'paid' => 0,
        'climate_paid' => 0,
        'status' => self::STATUS_UNSETTLED,
    ];

    public function getPriceAttribute(): float
    {
        if ($this->days === 0) {
            return 0;
        }

        return floor($this->days * $this->price_per_day * (100 - $this->discount) / 100);
    }

    public function getClimatePriceAttribute(): float
    {
        $clientItems = $this->clientItems;
        $price = 0;
        foreach ($clientItems as $clientItem) {
            if ($clientItem->serviceCategory && $clientItem->serviceCategory->name == 'Klimatyczne') {
                $price += $clientItem->price * $clientItem->count;
            }
        }

        return $price * $this->days;
    }

    public function getPricePerDayAttribute(): float
    {
        $clientItems = $this->clientItems;
        $price = 0;
        foreach ($clientItems as $clientItem) {
            if (!$clientItem->serviceCategory || $clientItem->serviceCategory->name != 'Klimatyczne') {
                $price += $clientItem->price * $clientItem->count;
            }
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
