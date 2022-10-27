<?php

namespace App\Repositories;

use App\Http\Resources\Public\CategoryResource;
use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function all(){
        return CategoryResource::collection($this->model->where('category_parent',null)->with('childs')->get());
    }
}
