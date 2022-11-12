<?php

namespace App\Http\Resources\Public;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->{Category::COL_ID},
            'name' => $this->{Category::COL_NAME},
            'childs' => $this->when($this->{Category::COL_PARENT} == null, $this->collection($this->childs)),
        ];
    }
}
