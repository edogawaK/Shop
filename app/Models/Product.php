<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "product";
    public $primaryKey = "product_id";
    public $timestamps = false;
    public $guarded = [
        'product_price',
        'product_cost',
        'product_sold',
    ];

    public function images()
    {
        return $this->hasMany(Image::class, "product_id", "product_id");
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, "product_size", "product_id", "size_id")->withPivot(["quantity"]);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'product_id', 'product_id');
    }
}
