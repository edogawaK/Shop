<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;
    const COL_ID = 'size_id';
    const COL_NAME = 'size_name';
    const COL_STATUS = 'size_status';

    public $table = "size";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
}
