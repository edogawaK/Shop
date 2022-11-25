<?php

namespace App\Http\Resources\Public;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
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
            'date' => date_format(date_create($this->{Order::COL_RECEIVE}, timezone_open("Europe/Oslo")),'d-m-Y'),
            
        ];
    }
}
