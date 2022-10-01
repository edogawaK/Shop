<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "sale";
    public $primaryKey = "sale_id";
    public $timestamps = false;
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'sale_id', 'sale_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
