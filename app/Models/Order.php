<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const COL_ID = 'order_id';
    const COL_DATE = 'order_date';
    const COL_RECEIVE = 'order_receive';
    const COL_SHIP = 'order_ship';
    const COL_TOTAL = 'order_total';
    const COL_STATUS = 'order_status';
    const COL_USER = 'user_id';
    const COL_LOCATE = 'locate_id';

    public $table = "order";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_DATE,
        self::COL_RECEIVE,
        self::COL_SHIP,
        self::COL_TOTAL,
        self::COL_STATUS,
        self::COL_USER,
        self::COL_LOCATE,
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_detail', self::COL_ID, Product::COL_ID)->withPivot([Size::COL_ID, 'quantity']);
    }

    public function locate()
    {
        return $this->belongsTo(Locate::class, self::COL_LOCATE, Locate::COL_ID);
    }

    public function detail()
    {
        return $this->hasMany(OrderDetail::class, OrderDetail::COL_ORDER, self::COL_ID);
    }

    public function rate()
    {
        return $this->hasMany(Rate::class, Rate::COL_ORDER, self::COL_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, self::COL_USER, User::COL_ID);
    }
}
