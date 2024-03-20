<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteItemRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Repositories\ItemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        $query = Item::query();
        if (Auth::user()->role != "admin")
            $query->where('user_id', Auth::user()->id);
        $items = $query->with(['category', 'activeDiscount'])->get();
        return $this->sendResponse(ItemResource::collection($items), "Items List");
    }

    public function store(StoreItemRequest $storeItemRequest)
    {
        $item = $this->itemRepository->storeItem($storeItemRequest->category_id, $storeItemRequest->name,
            $storeItemRequest->description, $storeItemRequest->price, $storeItemRequest->user_id);
        return $this->sendResponse(new ItemResource($item), "Item Created");
    }

    public function destroy(DeleteItemRequest $deleteItemRequest)
    {
        $item = $this->itemRepository->deleteItem($deleteItemRequest->id);
        return $this->sendResponse(true, "Item Deleted");
    }
}
