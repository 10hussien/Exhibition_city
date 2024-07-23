<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\utils\imageupload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{

    public function allDepartment()
    {
        $departments = Department::all();
        foreach ($departments as $department) {
            $department->image_department = asset('images/' . $department->image_department);
        }
        return response()->json($departments, 200);
    }

    public function addDepartment(DepartmentRequest $request)
    {

        $department = $request->all();
        if ($image = $request->file('image_department')) {
            $department['image_department'] = (new imageupload)->uploadimage($image);
        }
        $department['user_id'] = Auth::id();
        $department['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $department['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        Department::create($department);
        return response()->json(__('words.The department has been added successfully'), 200);
    }

    public function departmentInformation($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(__('words.Department not found'), 404);
        }
        $department->image_department = asset('images/' . $department->image_department);
        return response()->json($department);
    }


    public function Departmentcompanies($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(__('words.Department not found'), 404);
        }

        if (empty($department->companies) || $department->companies->isEmpty()) {
            return response()->json(__('words.There are no companies in this department'), 200);
        } else {

            $Companies = $department->companies;
            foreach ($Companies as $company) {
                $company->company_logo = asset('images/' . $company->company_logo);
            }
            return response()->json($Companies, 200);
        }
    }




    public function editDepartment(Request $request, $id)
    {
        $edit = Department::find($id);
        if (!$edit) {
            return response()->json(__('words.Department not found'), 404);
        }
        if ($image = $request->file('image_department')) {
            $edit['image_department'] = (new imageupload)->uploadimage($image);
        } else {
            unset($input['image_department']);
        }
        if ($request->has('name_department')) {
            $edit->name_department = $request->input('name_department');
        }
        $edit['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $updated = $edit->save();
        if ($updated) {
            return response()->json(__('words.The department has been edit successfully'), 200);
        } else {
            return response()->json(__('words.Failed to edit the department'), 500);
        }
    }


    public function deleteDepartment($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(__('words.Department not found'), 404);
        }
        // $department->companies->delete();
        foreach ($department->companies as $companies) {
            $companies->delete();
        }
        $department->delete();
        return response()->json(__('words.The department has been delete successfully'), 200);
    }
}
