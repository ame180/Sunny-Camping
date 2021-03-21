<?php

namespace App\Models;

use Database\Factories\ClientItemFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\ClientItem.
 *
 * @property int $id
 * @property int $service_id
 * @property int $category_id
 * @property int $client_id
 * @property string $name
 * @property float $price
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ClientItemFactory factory(...$parameters)
 * @method static Builder|ClientItem newModelQuery()
 * @method static Builder|ClientItem newQuery()
 * @method static Builder|ClientItem query()
 * @method static Builder|ClientItem whereCategoryId($value)
 * @method static Builder|ClientItem whereClientId($value)
 * @method static Builder|ClientItem whereCount($value)
 * @method static Builder|ClientItem whereCreatedAt($value)
 * @method static Builder|ClientItem whereId($value)
 * @method static Builder|ClientItem whereName($value)
 * @method static Builder|ClientItem wherePrice($value)
 * @method static Builder|ClientItem whereServiceId($value)
 * @method static Builder|ClientItem whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ClientItem extends BaseModel
{
    protected $guarded = [];

    use HasFactory;
}
