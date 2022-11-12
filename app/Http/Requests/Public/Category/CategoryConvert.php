<?php

namespace App\Http\Requests\Public\Category;

use App\Models\Category;

trait CategoryConvert
{
    public function convert()
    {
        return array_filter([
            Category::COL_NAME => $this->name,
            Category::COL_PARENT => $this->parent,
            Category::COL_STATUS => $this->status,
        ]);
    }
}
