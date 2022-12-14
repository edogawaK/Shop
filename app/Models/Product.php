<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const COL_ID = 'product_id';
    const COL_NAME = 'product_name';
    const COL_AVT = 'product_avt';
    const COL_PRICE = 'product_price';
    const COL_COST = 'product_cost';
    const COL_DATE = 'product_date';
    const COL_SOLD = 'product_sold';
    const COL_DESC = 'product_desc';
    const COL_STATUS = 'product_status';
    const COL_RATE = 'product_rate';
    const COL_RATE_COUNT = 'product_rate_count';
    const COL_SALE = 'sale_id';
    const COL_CATEGORY = 'category_id';

    public $table = "product";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_AVT,
        self::COL_CATEGORY,
        self::COL_DESC,
        self::COL_NAME,
        self::COL_RATE,
        self::COL_RATE_COUNT,
        self::COL_SOLD,
        self::COL_SALE,
        self::COL_COST,
        self::COL_PRICE,
        self::COL_SOLD,
        self::COL_STATUS,
    ];

    public function images()
    {
        return $this->hasMany(Image::class, Image::COL_PRODUCT, self::COL_ID);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, "product_size", self::COL_ID, Size::COL_ID)->withPivot(["quantity"]);
    }

    public function size($sizeID)
    {
        return $this->sizes()->wherePivot(Size::COL_ID, $sizeID);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, self::COL_CATEGORY, Category::COL_ID);
    }

    public function avatar()
    {
        return $this->belongsTo(Image::class, self::COL_AVT, Image::COL_ID);
    }
}
