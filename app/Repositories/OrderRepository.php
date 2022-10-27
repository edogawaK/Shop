<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function all($options = ['filters' => [], 'sort' => null, 'sortMode' => null])
    {
        $query = $this->model;

        if ($options['filters']) {
            foreach ($options['filters'] as $filter) {
                $query = $query->where(...$filter);
            }
        }

        if ($options['sort']) {
            $query = $query->orderBy($options['sort'], $options['sortMode']);
        }

        $data = $query->paginate($this->pageSize);

        return Order::collection($data);
    }
}
