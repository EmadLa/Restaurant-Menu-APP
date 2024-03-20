<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//            'activeDiscount' => $this->activeDiscount->first()->activeDiscount,
            'id' => $this->id,
            'category_id' => $this->category_id,
            'parent' => $this->category->parent,
            'category_name' => $this->category?->name,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_value' => $this->item_discount_value,
            'price_after_discount' => round($this->price - $this->item_discount_value, 2),
        ];
    }
}
