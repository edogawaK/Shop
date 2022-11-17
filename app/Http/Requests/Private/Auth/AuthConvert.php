<?php

namespace App\Http\Requests\Private\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

trait AuthConvert
{
    public function convert()
    {
        return array_filter([
            Admin::COL_ID => $this->id,
            Admin::COL_EMAIL => $this->email,
            Admin::COL_NAME => $this->name,
            Admin::COL_PASSWORD => $this->password,
            Admin::COL_PHONE => $this->phone,
            Admin::COL_ROLE => $this->role,
            Admin::COL_STATUS => $this->status,
        ]);
    }
}
