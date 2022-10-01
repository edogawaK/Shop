<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "order";
    public $primaryKey = "order_id";
    public $timestamps = false;
    public $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_detail', 'order_id', 'product_id')->withPivot(['size_id', 'quantity']);
    }

    public function locate()
    {
        return $this->belongsTo(Locate::class, 'locate_id', 'locate_id');
    }
}
