<?php

namespace App\Models;

use Database\Factories\ServiceCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ServiceCategory.
 *
 * @property int $id
 * @property int $service_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Item[] $categoryItems
 * @property-read int|null $category_items_count
 * @method static ServiceCategoryFactory factory(...$parameters)
 * @method static Builder|ServiceCategory newModelQuery()
 * @method static Builder|ServiceCategory newQuery()
 * @method static Builder|ServiceCategory query()
 * @method static Builder|ServiceCategory whereCreatedAt($value)
 * @method static Builder|ServiceCategory whereId($value)
 * @method static Builder|ServiceCategory whereName($value)
 * @method static Builder|ServiceCategory whereServiceId($value)
 * @method static Builder|ServiceCategory whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|\App\Models\Item[] $serviceCategoryItems
 * @property-read int|null $service_category_items_count
 */
class ServiceCategory extends BaseModel
{
    use HasFactory;

    public function serviceCategoryItems(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
