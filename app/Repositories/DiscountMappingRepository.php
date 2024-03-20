<?php

namespace App\Repositories;

use App\Models\DiscountMapping;
use Illuminate\Support\Facades\Auth;

class DiscountMappingRepository
{
    public function storeDiscountItem($discountId, $itemId, $userId=null): DiscountMapping
    {
        $record = new DiscountMapping();
        if (Auth::user()->role != "admin")
            $record->user_id = Auth::user()->id;
        else
            $record->user_id = $userId;
        $record->discount_id = $discountId;
        $record->item_id = $itemId;
        $record->save();
        return $record;
    }

    public function storeDiscountCategory($discountId, $categoryId, $userId = null): DiscountMapping
    {
        $record = new DiscountMapping();
        if (Auth::user()->role != "admin")
            $record->user_id = Auth::user()->id;
        else
            $record->user_id = $userId;
        $record->discount_id = $discountId;
        $record->category_id = $categoryId;
        $record->save();
        return $record;
    }
}
