<?php

namespace App\Http\Resources\Private;

use App\Models\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'id' => $this->{Admin::COL_ID},
            'name' => $this->{Admin::COL_NAME},
            'phone' => $this->{Admin::COL_PHONE},
            'email' => $this->{Admin::COL_EMAIL},
            'role' => $this->{Admin::COL_ROLE},
            'status' => $this->{Admin::COL_STATUS},
        ];
    }
}
