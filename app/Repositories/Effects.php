<?php

namespace App\Repositories;

use App\Models\Rate;

trait Effects
{
    public function attachFilter($query, $filters)
    {
        if ($filters) {
            foreach ($filters as $filter) {
                $query = $query->where(...$filter);
            }
        }
        return $query;
    }
    public function attachSort($query, $sort, $sortMode = 'asc')
    {
        if ($sort) {
            $query = $query->orderBy($sort, $sortMode);
        }
        return $query;
    }
}
