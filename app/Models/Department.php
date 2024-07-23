<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'image_department',
        'name_department',
        'number_company',
    ];

    public function companies()
    {
        return $this->belongsToMany(CompanyInformation::class, 'department_companies', 'department_id', 'company_information_id');
    }
}
