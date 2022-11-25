<?php

namespace App\Http\Resources\Public;

use App\Models\Locate;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->{User::COL_ID},
            'name' => $this->{User::COL_NAME},
            'email' => $this->{User::COL_EMAIL},
            'phone' => $this->locates->{Locate::COL_PHONE},
            'address' => $this->locates->{Locate::COL_STREET},
            'status' => $this->{User::COL_STATUS},
            'token' => $this->when($this->token, $this->token),
        ];
    }
}
