<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "rate";
    public $primaryKey = "rate_id";
    public $timestamps = false;
    public $guarded = [];
}
