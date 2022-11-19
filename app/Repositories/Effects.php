<?php

namespace App\Repositories;

use App\Models\Rate;

trait Effects
{
    public $canFilter = [];
    public $canSort = [];
    public $canSearch = [];

    public function attachFilter($query, $filters)
    {
        if ($filters) {
            foreach ($filters as $filter) {
                // if ($filters[$filter] ?? null) {
                $query = $query->where(...$filter);
                // }
            }
        }
        return $query;
    }
    public function attachSort($query, $sort, $sortMode = 'asc')
    {
        if ($sort) {
            // if($canSort[$sort]){
            $query = $query->orderBy($sort, $sortMode);
            // }
        }
        return $query;
    }
}
