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
 */
class Client extends BaseModel
{
    use HasFactory;
    protected $guarded = [];

    public function clientItems(): HasMany
    {
        return $this->hasMany(ClientItem::class);
    }
}
