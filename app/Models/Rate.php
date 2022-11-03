<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    const COL_ID = 'rate_id';
    const COL_CONTENT = 'rate_content';
    const COL_POINT = 'rate_point';
    const COL_DATE = 'rate_date';
    const COL_USER = 'user_id';
    const COL_PRODUCT = 'product_id';

    public $table = "rate";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
}
