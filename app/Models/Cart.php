<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;

    const COL_ID = 'cart_id';
    const COL_QUANTITY = 'cart_quantity';
    const COL_SIZE = 'size_id';
    const COL_PRODUCT = 'product_id';
    const COL_USER = 'user_id';

    public $table = "cart";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_PRODUCT,
        self::COL_SIZE,
        self::COL_QUANTITY,
        self::COL_USER,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, self::COL_USER, User::COL_ID);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, self::COL_PRODUCT, Product::COL_ID);
    }

    public function size()
    {
        return $this->belongsTo(Size::class, self::COL_SIZE, Size::COL_ID);
    }
}
