<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->hasMany(CompanyInformation::class, 'user_id', 'id');
    }
    public function department()
    {
        return $this->hasMany(Department::class, 'user_id', 'id');
    }

    public function followers()
    {
        return $this->belongsToMany(CompanyInformation::class, 'followers', 'user_id', 'company_information_id');
    }
    public function comments()
    {
        return $this->belongsToMany(Product::class, 'comments', 'user_id', 'product_id');
    }
    public function favourite()
    {
        return $this->belongsToMany(Product::class, 'favourites', 'user_id', 'product_id');
    }
}
