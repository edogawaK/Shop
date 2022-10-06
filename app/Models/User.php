<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $table = "user";
    public $primaryKey = "user_id";
    public $timestamps = false;
    public $guarded = [];
    protected $hidden = [
        'user_password',
    ];
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function cart()
    {
        return $this->belongsToMany(Product::class, 'cart', 'user_id', 'product_id')->withPivot(['size_id', 'cart_quantity']);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function locates()
    {
        return $this->belongsTo(Locate::class, 'locate_id', 'locate_id');
    }
}
