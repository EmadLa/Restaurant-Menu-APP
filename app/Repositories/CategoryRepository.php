<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CategoryRepository
{
    public function storeCategory($name, $lastChild, $path, $parentId = null, $userId = null): Category
    {
        $category = new Category();
        if (Auth::user()->role != "admin")
            $category->user_id = Auth::user()->id;
        else
            $category->user_id = $userId;
        $category->name = $name;
        $category->last_child = $lastChild;
        $category->parent_id = $parentId;
        $category->path = $path;
        $category->save();
        return $category;
    }
    public function getCategoriesByIds($ids): Collection|array
    {
        return Category::query()->find($ids)->get();
    }

    public function getParentCategories(): Collection|array
    {
        return Category::query()->whereNull('parent_id')->get();
    }

}
