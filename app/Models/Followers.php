<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_information_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function companies()
    {
        return $this->belongsToMany(CompanyInformation::class);
    }
}
