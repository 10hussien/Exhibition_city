<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\CompanyInformation;
use App\Models\Department;
use App\Models\Department_company;
use App\utils\imageupload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyInformationController extends Controller
{

    public function allCommpany()
    {
        $Companies = CompanyInformation::all();
        foreach ($Companies as $company) {
            $company->company_logo = asset('images/' . $company->company_logo);
            if ($company['admission'] == 'accepted') {
                $all_company[] = $company;
            }
        }
        try {
            return response()->json($all_company, 200);
        } catch (\Throwable $th) {
            return response()->json(__('words.not found companies'), 200);
        }
    }

    public function addCompany(Request $request)
    {
        $validationData = $request->all();

        if ($image = $request->file('company_logo')) {
            $validationData['company_logo'] = (new imageupload)->uploadimage($image);
        }

        $validationData['user_id'] = Auth::id();
        $validationData['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $validationData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        CompanyInformation::create($validationData);
        return response()->json(__('words.The company has been added successfully'), 200);
    }

    public function companyInformation($id)
    {
        $company = CompanyInformation::find($id);
        if (!$company && $company['admission'] != 'accepted') {
            return response()->json(__('words.Company not found'), 404);
        } else {

            $company->company_logo = asset('images/' .  $company->company_logo);
            if ($company && $company['admission'] == 'accepted') {
                return response()->json($company, 200);
            } else {
                return response()->json(__('words.This company does not actually exist'), 404);
            }
        }
    }

    public function editCompany(Request $request, $id)
    {
        $edit = CompanyInformation::find($id);
        if (!$edit && $edit['admission'] != 'accepted') {
            return response()->json(__('words.Company not found'), 404);
        }
        if ($image = $request->file('company_logo')) {
            $edit['company_logo'] = (new imageupload)->uploadimage($image);
        } else {
            unset($company['company_logo']);
        }
        if ($request->has('department')) {
            return response()->json(__('words.It is not possible to modify the company department'), 200);
        }

        if ($request->has('company_name')) {
            $edit->company_name = $request->input('company_name');
        }
        if ($request->has('company_address')) {
            $edit->company_address = $request->input('company_address');
        }
        if ($request->has('company_email')) {
            $edit->company_email = $request->input('company_email');
        }
        if ($request->has('bio')) {
            $edit->bio = $request->input('bio');
        }
        if ($request->has('facebook')) {
            $edit->facebook = $request->input('facebook');
        }
        $update = $edit->save();
        if ($update) {
            return response()->json(__('words.Company information has been modified'), 200);
        } else {
            return response()->json(__('words.Failed to edit the company'), 500);
        }
    }


    public function deleteCompany($id)
    {
        $company = CompanyInformation::find($id);
        if ($company) {
            // $department = Department::where('name_department', $company['department'])->first();
            // $department->number_company--;
            $company->depatments->number_compnay--;
            // $department->save();
            $company->depatments->save();
            $delete = Department_company::where('company_information_id', $id);
            $company->products->delete();
            $delete->delete();
            $company->delete();
            return response()->json(__('words.The department has been delete successfully'), 200);
        } else {
            return response()->json(__('words.This company does not actually exist', 404));
        }
    }

    public function companyProduct($id)
    {
        $company = CompanyInformation::find($id);
        if (!$company->products->isEmpty()) {
            foreach ($company->products as $product) {
                $product->image = asset('images/' . $product->image);
            }
            return response()->json($company->products, 200);
        } else {
            return response()->json(__('words.There are no products from this company currently'));
        }
    }
}
