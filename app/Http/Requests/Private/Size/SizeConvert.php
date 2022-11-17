<?php

namespace App\Http\Requests\Private\Size;

use App\Models\Size;
use Illuminate\Foundation\Http\FormRequest;

trait SizeConvert{
    public function convert()
    {
        return [
            Size::COL_NAME=>$this->name,
        ];
    }
}
