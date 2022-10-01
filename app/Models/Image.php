<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "image";
    public $primaryKey = "image_id";
    public $timestamps = false;
    public $guarded = [];
}
