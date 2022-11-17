<?php

namespace App\Http\Requests\Private\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

trait CategoryConvert
{
    public function convert()
    {
        return [
            Category::COL_PARENT => $this->parent,
            Category::COL_NAME => $this->name,
        ];
    }
}
