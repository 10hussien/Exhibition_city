<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use App\Models\Followers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowersController extends Controller
{

    public function addFollow($id)
    {
        $user_id = Auth::id();
        $company_id = $id;
        Followers::firstOrCreate([
            'user_id' => $user_id,
            'company_information_id' => $company_id
        ]);
        return response()->json(__('words.Followed this company'));
    }

    public function userIsFollowing()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $companies = $user->followers;
        $count = $user->followers()->count();
        return response()->json([
            'Following' =>  $count,
            'companies' => $companies
        ]);
    }

    public function companyFollowers($id)
    {
        $company = CompanyInformation::find($id);
        $users = $company->followers;
        $count = $company->followers()->count();
        return response()->json([
            'Following' =>  $count,
            'companies' => $users
        ]);
    }


    public function unFollow($id)
    {
        $user_id = Auth::id();
        $company_id = $id;
        $user = User::find($user_id);
        $user->followers()->detach($company_id);
        return response()->json(__('words.Successfully unfollowed'));
    }
}
