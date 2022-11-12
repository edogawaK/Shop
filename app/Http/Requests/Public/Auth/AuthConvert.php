<?php

namespace App\Http\Requests\Public\Auth;

use App\Models\Locate;
use App\Models\User;

trait AuthConvert
{
    public function convert()
    {
        return array_filter([
            User::COL_EMAIL => $this->email,
            User::COL_NAME => $this->name,
            User::COL_PASSWORD => $this->password,
            Locate::COL_CITY => $this->city,
            Locate::COL_DISTRICT => $this->district,
            Locate::COL_WARD => $this->ward,
            Locate::COL_PHONE => $this->phone,
            Locate::COL_STREET => $this->street,
            Locate::COL_RECEIVER => $this->name,
        ]);
    }
}
