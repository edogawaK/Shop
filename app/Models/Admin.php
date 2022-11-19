<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * About the User Entity
 * @package App\Models
 *
 * ==== Properties - Fields
 * @property string admin_id
 * @property string admin_
 */
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    public $fillable=[
        self::COL_EMAIL,
        self::COL_NAME,
        self::COL_PHONE,
    ];

    public function getAuthPassword()
    {
        return $this->{self::COL_PASSWORD};
    }
}
