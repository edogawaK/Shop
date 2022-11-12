<?php

namespace App\Http\Requests\Public\Size;

use App\Models\Size;

trait SizeConvert
{
    function convert()
    {
        return array_filter([
            Size::COL_ID => $this->id,
            Size::COL_NAME => $this->name,
            Size::COL_STATUS => $this->status,
        ]);
    }
}
