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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_detail', self::COL_ID, Product::COL_ID)->withPivot([Size::COL_ID, 'quantity']);
    }

    public function locate()
    {
        return $this->belongsTo(Locate::class, self::COL_LOCATE, Locate::COL_ID);
    }
}
