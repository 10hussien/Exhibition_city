<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department_company extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_id',
        'company_information_id'
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
    public function companies()
    {
        return $this->belongsToMany(CompanyInformation::class);
    }
}
