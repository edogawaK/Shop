<?php

namespace App\Repositories;

use App\Models\Rate;

class RateRepository extends BaseRepository
{
    public function __construct(Rate $model)
    {
        parent::__construct($model);
    }
}
