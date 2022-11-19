<?php

namespace App\Http\Requests\Public\Image;

use App\Models\Image;

trait ImageConvert
{
    public function convert()
    {
        return [
            'image' => $this->image,
            'isAvatar' => $this->isAvatar,
            Image::COL_PRODUCT => $this->productId,
            Image::COL_ID => $this->id,
        ];
    }
}
