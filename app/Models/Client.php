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
 * @property int                     $id
 * @property string                  $name
 * @property string|null             $arrival_date
 * @property string|null             $departure_date
 * @property string|null             $comment
 * @property int                     $discount
 * @property float                   $paid
 * @property string                  $status
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property Collection|ClientItem[] $clientItems
 * @property int|null                $client_items_count
 * @property int                     $days
 * @property float                   $price
 * @property float                   $price_per_day
 *
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
 *
 * @property float    $climate_paid
 * @property float    $climate_price
 * @property int|null $token_number
 *
 * @method static Builder|Client whereClimatePaid($value)
 *
 * @property int         $unregistered
 * @property int         $cash_register
 * @property int         $terminal
 * @property int         $voucher
 * @property int         $invoice
 * @property string|null $sector
 * @property string|null $car_registration
 *
 * @method static Builder|Client whereCarRegistration($value)
 * @method static Builder|Client whereCashRegister($value)
 * @method static Builder|Client whereInvoice($value)
 * @method static Builder|Client whereSector($value)
 * @method static Builder|Client whereTerminal($value)
 * @method static Builder|Client whereTokenNumber($value)
 * @method static Builder|Client whereUnregistered($value)
 * @method static Builder|Client whereVoucher($value)
 */
class Client extends BaseModel
{
    use HasFactory;

    public const STATUS_SETTLED = 'settled';
    public const STATUS_UNSETTLED = 'unsettled';

    protected $guarded = ['price', 'price_per_day', 'days', 'climate_price'];
    protected $appends = ['price', 'price_per_day', 'days', 'climate_price'];
    protected $with = ['clientItems'];

    protected array $defaults = [
        'discount' => 0,
        'paid' => 0,
        'climate_paid' => 0,
        'status' => self::STATUS_UNSETTLED,
    ];

    public function getPriceAttribute(): float
    {
        if (0 === $this->days) {
            return 0;
        }

        $clientItems = $this->clientItems;
        $price = 0;
        foreach ($clientItems as $clientItem) {
            if ('Klimatyczne' == $clientItem->serviceCategory?->name) {
                continue;
            }

            $itemPrice = $clientItem->price * $clientItem->count;

            if ('Osoby' === $clientItem->serviceCategory?->name) {
                $itemPrice *= (100 - $this->discount) / 100;
            }

            $itemPrice *= $clientItem->days ?? $this->days;

            $price += $itemPrice;
        }

        return round($price, 2);
    }

    public function getPricePerDayAttribute(): float
    {
        if (0 === $this->days) {
            return 0;
        }

        return round($this->price / $this->days, 2);
    }

    public function getClimatePriceAttribute(): float
    {
        $clientItems = $this->clientItems;
        $price = 0;
        foreach ($clientItems as $clientItem) {
            if ($clientItem->serviceCategory && 'Klimatyczne' == $clientItem->serviceCategory->name) {
                $itemPrice = $clientItem->price * $clientItem->count;
                $itemPrice *= $clientItem->days ?? $this->days;
                $price += $itemPrice;
            }
        }

        return round($price, 2);
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
