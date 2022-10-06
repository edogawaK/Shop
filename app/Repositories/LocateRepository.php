<?php

namespace App\Repositories;

use App\Models\Locate;

class LocateRepository extends BaseRepository
{
    public function __construct(Locate $model)
    {
        parent::__construct($model);
    }
}
