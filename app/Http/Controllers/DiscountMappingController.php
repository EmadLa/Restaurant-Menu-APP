<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountMappingRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\DiscountMappingRepository;
use Illuminate\Http\Request;

class DiscountMappingController extends Controller
{
    public CategoryRepository $categoryRepository;
    public DiscountMappingRepository $discountMappingRepository;

    public function __construct(
        CategoryRepository        $categoryRepository,
        DiscountMappingRepository $discountMappingRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->discountMappingRepository = $discountMappingRepository;
    }

    public function store(StoreDiscountMappingRequest $storeDiscountMappingRequest)
    {
        $type = $storeDiscountMappingRequest->type;
        switch ($type) {
            case "all_menu":
                $categories = $this->categoryRepository->getParentCategories();
                foreach ($categories as $category) {
                    $this->discountMappingRepository->storeDiscountCategory($storeDiscountMappingRequest->discount_id, $category->id, $storeDiscountMappingRequest->user_id);
                }
                break;
            case "categories":
                $categories = $this->categoryRepository->getCategoriesByIds($storeDiscountMappingRequest->categories);
                foreach ($categories as $category) {
                    $this->discountMappingRepository->storeDiscountCategory($storeDiscountMappingRequest->discount_id, $category->id, $storeDiscountMappingRequest->user_id);
                }
                break;
            case "item":
                $this->discountMappingRepository->storeDiscountItem($storeDiscountMappingRequest->discount_id, $storeDiscountMappingRequest->item_id, $storeDiscountMappingRequest->user_id);
                break;
        }
        return $this->sendResponse([], 'Discount Created');
    }
}
