<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    const COL_ID = 'image_id';
    const COL_LINK = 'image_link';
    const COL_PRODUCT = 'product_id';

    public $table = "image";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
}
