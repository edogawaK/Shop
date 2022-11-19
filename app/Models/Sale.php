<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;

    const COL_ID = 'sale_id';
    const COL_DISCOUNT = 'sale_discount';
    const COL_NAME = 'sale_name';
    const COL_UNIT = 'sale_unit';
    const COL_STATUS = 'sale_status';
    const COL_DATE = 'sale_date';
    const COL_END = 'sale_end';
    const COL_ADMIN = 'admin_id';

    public $table = "sale";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $appends = ['total'];

    public function products()
    {
        return $this->hasMany(Product::class, Product::COL_SALE, self::COL_ID);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, self::COL_ADMIN, Admin::COL_ID);
    }

    public function getTotalAttribute()
    {
        return $this->products()->count();
    }
}
