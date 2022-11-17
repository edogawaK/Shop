<?php

namespace App\Http\Requests\Private\Sale;

use App\Models\Sale;
use Illuminate\Foundation\Http\FormRequest;

trait SaleConvert
{
    public function convert()
    {
        return array_filter([
            Sale::COL_ADMIN => $this->adminId,
            Sale::COL_DISCOUNT => $this->discount,
            Sale::COL_END => $this->endDate,
            Sale::COL_NAME => $this->name,
            Sale::COL_UNIT => $this->unit,
        ]);
    }
}
