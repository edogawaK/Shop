<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const COL_ID = 'user_id';
    public const COL_NAME = 'user_name';
    public const COL_PASSWORD = 'user_password';
    public const COL_EMAIL = 'user_email';
    public const COL_LOCATE = 'locate_id';
    public const COL_POINT = 'user_point';
    public const COL_STATUS = 'user_status';

    public $table = "user";
    public $primaryKey = self::COL_ID;
    public $timestamps = false;
    public $fillable = [
        self::COL_NAME,
        self::COL_PASSWORD,
        self::COL_EMAIL,
        self::COL_LOCATE,
    ];

    protected $hidden = [
        self::COL_PASSWORD,
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, Cart::COL_USER, self::COL_ID);
        // return $this->belongsToMany(Product::class, 'cart', 'user_id', 'product_id')->withPivot(['size_id', 'cart_quantity']);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, Order::COL_USER, self::COL_ID);
    }

    public function locates()
    {
        return $this->belongsTo(Locate::class, self::COL_LOCATE, Locate::COL_ID);
    }

    public function getAuthPassword()
    {
        return $this->user_password;
    }
}
