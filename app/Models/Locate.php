<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locate extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "locate";
    public $primaryKey = "locate_id";
    public $timestamps = false;
    public $guarded = [];
}
