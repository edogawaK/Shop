<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    const COL_ID = 'order_detail_id';
    const COL_QUANTITY = 'order_detail_quantity';
    const COL_ORDER = 'order_id';
    const COL_PRODUCT = 'product_id';
    const COL_SIZE = 'size_id';

    public $table = "order_detail";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_ID,
        self::COL_ORDER,
        self::COL_PRODUCT,
        self::COL_QUANTITY,
        self::COL_SIZE,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, self::COL_PRODUCT, Product::COL_ID);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, self::COL_ORDER, Order::COL_ID);
    }

    public function size()
    {
        return $this->belongsTo(Size::class, self::COL_SIZE, Size::COL_ID);
    }
}
