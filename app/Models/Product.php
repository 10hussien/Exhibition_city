<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'price',
        'quantity',
        'data',
        'company_id'
    ];


    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }



    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyInformation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'product_id');
    }


    public function favourite()
    {
        return $this->belongsToMany(User::class, 'favourites', 'product_id', 'user_id');
    }
}
