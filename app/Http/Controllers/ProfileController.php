<?php

namespace App\Http\Controllers;

use App\Http\Requests\profileRequest;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Ramsey\Uuid\Type\Integer;

class ProfileController extends Controller
{

    public function addProfile(ProfileRequest $request)
    {
        $check = Profile::where('user_id', Auth::id())->exists();
        if ($check == false) {
            $profile = $request->all();
            $profile['user_id'] = Auth::id();
            $profile['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $profile['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            Profile::create($profile);
            return response()->json(__('words.add profile successfully'), 200);
        } else {
            return response()->json(__('words.The profile already exists'), 200);
        }
    }

    public function showProfile()
    {
        $id   = Auth::id();
        $user = User::find($id);
        $profile = $user->profile;
        return response()->json($user, 200);
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if ($user->profile) {
            if ($request->has('first_name')) {
                $user->first_name = $request->input('first_name');
            }
            if ($request->has('last_name')) {
                $user->last_name = $request->input('last_name');
            }
            if ($request->has('phone')) {
                $user->phone = $request->input('phone');
            }
            if ($request->has('address')) {
                $user->profile->address = $request->input('address');
            }
            if ($request->has('age')) {
                $user->profile->age = $request->input('age');
            }
            if ($request->has('facebook')) {
                $user->profile->facebook = $request->input('facebook');
            }
            if ($request->has('gender')) {
                $user->profile->gender = $request->input('gender');
            }
            $user->profile['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $user->profile['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            // $user->save();
            $user->profile->save();
            return response()->json(__('words.update profile successfully'), 200);
        } else {
            return response()->json(__('words.The profile does not exist'), 200);
        }
    }

    public function deleteProfile()
    {
        $user = Auth::user();
        $user->profile->delete();
        return response()->json(__('words.delete profile successfully'));
    }
}
