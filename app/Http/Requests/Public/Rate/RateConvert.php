<?php

namespace App\Http\Requests\Public\Rate;

use App\Models\Rate;
use App\Models\User;

trait RateConvert
{
    public function convert()
    {
        return [
            Rate::COL_USER => $this->user()->{User::COL_ID},
            Rate::COL_PRODUCT => $this->productId,
            Rate::COL_POINT => $this->point,
            Rate::COL_CONTENT => $this->input('content'),
        ];
    }
}
