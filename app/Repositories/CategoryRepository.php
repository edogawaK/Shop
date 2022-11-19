<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getCategories()
    {
        $categories = Category::where(Category::COL_PARENT, null)->with('childs')->get();
        return $categories;
    }
    public function storeCategory($data)
    {
        $category = Category::create($data);
        return $category;
    }
    public function updateCategory($id, $data)
    {
        $category = Category::find($id);
        $category->update($data);
        return $category;
    }
    public function destroyCategory($id)
    {
        $result = Category::find($id)->delete();
        return $result;
    }
}
