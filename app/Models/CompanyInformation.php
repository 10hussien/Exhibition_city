<?php

namespace App\Models;

use App\Observers\CompanyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CompanyInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'department',
        'company_logo',
        'company_name',
        'company_address',
        'company_email',
        'bio',
        'facebook',
        'admission'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_companies', 'company_information_id', 'department_id');
    }

    protected static function boot()
    {
        parent::boot();
        CompanyInformation::observe(CompanyObserver::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'company_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'company_information_id', 'user_id');
    }
}
