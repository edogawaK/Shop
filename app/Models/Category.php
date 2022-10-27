<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    const COL_ID = 'category_id';
    const COL_NAME = 'category_name';
    const COL_PARENT = 'category_parent';
    const COL_STATUS = 'category_status';

    public $table = "category";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, Product::COL_CATEGORY, self::COL_ID);
    }

    public function childs()
    {
        return $this->hasMany(Category::class, Category::COL_PARENT, self::COL_ID);
    }
}
