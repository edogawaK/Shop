<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory, SoftDeletes;

    const COL_ID = 'admin_id';
    const COL_NAME = 'admin_name';
    const COL_PHONE = 'admin_phone';
    const COL_EMAIL = 'admin_email';
    const COL_PASSWORD = 'admin_password';
    const COL_ROLE = 'admin_role';
    const COL_STATUS = 'admin_status';

    public $table = "admin";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;

}
