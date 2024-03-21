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
            'id' => $this->id,
                'category_id' => $this->category_id,
            'category_name' => $this->category?->name,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'item_discount' => $this->item_discount_value ?? 0,
            'category_discount' => $this->item_category_discount_value ?? 0,
            'price_after_discount' => $this->price_after_discount,
        ];
    }
}
