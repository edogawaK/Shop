<?php

namespace App\Repositories;

use App\Models\Rate;

trait Effects
{
    protected $filtables = [];
    public $sortables = [];
    public $searchables = [];

    public function attachFilter($query, $filters)
    {
        if ($filters) {
            foreach ($this->filtables as $filter) {
                if ($filters[$filter] ?? null) {
                    $query = $query->where(...$filters[$filter]);
                }
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
    public function filterRules($rules)
    {

    }
}
