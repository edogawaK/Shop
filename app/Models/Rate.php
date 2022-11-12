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
    const COL_ORDER = 'order_id';

    public $table = "rate";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_CONTENT,
        self::COL_POINT,
        self::COL_PRODUCT,
        self::COL_USER,
        self::COL_ORDER,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, self::COL_PRODUCT, Product::COL_ID);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, self::COL_ORDER, Order::COL_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, self::COL_USER, User::COL_ID);
    }
}
