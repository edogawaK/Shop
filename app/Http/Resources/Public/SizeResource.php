<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
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
            'id'=>$this->size_id,
            'name'=>$this->size_name,
            'status'=>$this->size_status,
        ];
    }
}
