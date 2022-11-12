<?php

namespace App\Repositories;

use App\Http\Resources\Public\CategoryResource;
use App\Models\Category;

class CategoryRepository
{
    public function getCategories()
    {
        return CategoryResource::collection(Category::where(Category::COL_PARENT, null)->with('childs')->get());
    }
    public function storeCategory($data)
    {
        return Category::create($data);
    }
    public function updateCategory($id, $data)
    {
        return Category::find($id)->update($data);
    }
    public function destroyCategory($id)
    {
        return Category::find($id)->delete();
    }
}
