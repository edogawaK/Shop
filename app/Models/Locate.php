<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locate extends Model
{
    use HasFactory, SoftDeletes;

    const COL_ID = 'locate_id';
    const COL_CITY = 'locate_city';
    const COL_WARD = 'locate_ward';
    const COL_DISTRICT = 'locate_district';
    const COL_STREET = 'locate_street';
    const COL_RECEIVER = 'locate_receiver';
    const COL_PHONE = 'locate_phone';

    public $table = "locate";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_CITY,
        self::COL_WARD,
        self::COL_DISTRICT,
        self::COL_STREET,
        self::COL_RECEIVER,
        self::COL_PHONE,
    ];
}
