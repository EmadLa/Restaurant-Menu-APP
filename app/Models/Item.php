<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'description', 'price'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function discountMappings(): HasMany
    {
        return $this->hasMany(DiscountMapping::class, 'item_id');
    }

    public function activeDiscount()
    {
        return $this->discountMappings()->with('activeDiscount');
    }

    public function getItemDiscountValueAttribute(): float
    {
        return round($this->activeDiscount?->first()?->activeDiscount?->value, 2);
    }

    public function getItemCategoryDiscountValueAttribute(): float
    {
        $categoryIds = explode(',', $this->category->path);
        $discountMapping = DiscountMapping::query()->whereIn('category_id', array_reverse($categoryIds))->with('activeDiscount')->first();
        return $discountMapping->activeDiscount?->value ?? 0.0;
    }

    public function getPriceAfterDiscountAttribute(): float
    {
        $price = $this->attributes['price'];
        $itemDiscount = $this->item_discount_value;
        $categoryDiscount = $this->item_category_discount_value;
        return round($price - $itemDiscount - $categoryDiscount, 2) < 0 ? 0 : round($price - $itemDiscount - $categoryDiscount, 2);
    }
}
