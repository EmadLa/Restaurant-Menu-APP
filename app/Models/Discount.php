<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Discount extends Model
{
    use HasFactory;

    protected $table = "discounts";

    protected $fillable = [
        'user_id', 'value', 'start_date', 'end_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discountMappings(): HasMany
    {
        return $this->hasMany(DiscountMapping::class, 'discount_id');
    }

    public function startDate(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::parse($this->attributes['start_date'])->format('Y-m.d h:i a'),
        );
    }

    public function endDate(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::parse($this->attributes['end_date'])->format('Y-m.d h:i a'),
        );
    }
}
