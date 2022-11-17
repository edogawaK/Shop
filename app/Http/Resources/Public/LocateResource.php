<?php

namespace App\Http\Resources\Public;

use App\Models\Locate;
use Illuminate\Http\Resources\Json\JsonResource;

class LocateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->{Locate::COL_ID},
            'city' => $this->{Locate::COL_CITY},
            'district' => $this->{Locate::COL_DISTRICT},
            'phone' => $this->{Locate::COL_PHONE},
            'receiver' => $this->{Locate::COL_RECEIVER},
            'street' => $this->{Locate::COL_STREET},
            'ward' => $this->{Locate::COL_WARD},
        ];
    }
}
