<?php

namespace App\Observers;

use App\Models\CompanyInformation;
use App\Models\Department;
use App\Models\Department_company;
use App\Models\User;


class CompanyObserver
{

    public function updated(CompanyInformation $companyInformation)
    {
        if ($companyInformation->admission == 'accepted') {
            $department_id = Department::where('name_department', $companyInformation->department)->first();
            Department_company::firstOrCreate([
                'department_id' => $department_id->id,
                'company_information_id' => $companyInformation->id
            ]);
            $user = $companyInformation->user;
            $user->status = 'admin';
            $user->save();
        }
    }
}
