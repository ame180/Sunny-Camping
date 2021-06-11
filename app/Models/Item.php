<?php

namespace App\Models;

use Database\Factories\ItemFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\Item.
 *
 * @property int $id
 * @property string $category_id
 * @property string $name
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ItemFactory factory(...$parameters)
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 * @method static Builder|Item whereCategoryId($value)
 * @method static Builder|Item whereCreatedAt($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item wherePrice($value)
 * @method static Builder|Item whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $service_category_id
 * @method static Builder|Item whereServiceCategoryId($value)
 */
class Item extends BaseModel
{
    use HasFactory;
}
