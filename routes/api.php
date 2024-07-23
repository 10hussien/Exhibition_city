<?php

use App\Http\Controllers\AdmissionsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CompanyInformationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(['auth:sanctum', 'setapplang'])->group(function () {

    Route::post('profile/addProfile', [ProfileController::class, 'addProfile'])
        ->name('profile.addProfile');

    Route::get('/profile/showProfile', [ProfileController::class, 'showProfile'])
        ->name('profile.showProfile');

    Route::post('/profile/updateProfile', [ProfileController::class, 'updateProfile'])
        ->name('profile.updateProfile');

    Route::get('/profile/deleteProfile', [ProfileController::class, 'deleteProfile'])
        ->name('profile.deleteProfile');
});



Route::middleware(['superAdmin', 'auth:sanctum', 'setapplang'])->group(function () {
    Route::post('/department/addDepartment', [DepartmentController::class, 'addDepartment'])
        ->name('addDepartment');
    Route::post('/department/editDepartment/{id}', [DepartmentController::class, 'editDepartment'])
        ->name('editDepartment');
    Route::get('/department/deleteDepartment/{id}', [DepartmentController::class, 'deleteDepartment'])
        ->name('deleteDepartment');
});

Route::get('/department/allDepartment', [DepartmentController::class, 'allDepartment'])
    ->name('allDepartment')
    ->middleware(['auth:sanctum', 'setapplang']);

Route::get('/department/Departmentcompanies/{id}', [DepartmentController::class, 'Departmentcompanies'])
    ->name('Departmentcompanies')
    ->middleware(['auth:sanctum', 'setapplang']);
Route::get('/department/departmentInformation/{id}', [DepartmentController::class, 'departmentInformation'])
    ->name('departmentInformation')
    ->middleware(['auth:sanctum', 'setapplang']);




Route::middleware(['auth:sanctum', 'setapplang'])->group(function () {
    Route::get('/company/allCompany', [CompanyInformationController::class, 'allCommpany'])
        ->name('allCommpany');
    Route::post('/company/addCompany', [CompanyInformationController::class, 'addCompany'])
        ->name('addCompany');
    Route::get('/company/companyInformation/{id}', [CompanyInformationController::class, 'companyInformation'])
        ->name('companyInformation');
    Route::get('/company/products/{id}', [CompanyInformationController::class, 'companyProduct'])
        ->name('companyproducts');
});

Route::middleware(['auth:sanctum', 'setapplang', 'companyControl'])->group(function () {
    Route::get('/company/deleteCompany/{id}', [CompanyInformationController::class, 'deleteCompany'])
        ->name('deleteCompany');
    Route::post('/company/editCompany/{id}', [CompanyInformationController::class, 'editCompany'])
        ->name('editCompany');
});

Route::middleware(['auth:sanctum', 'setapplang', 'superAdmin'])->group(function () {
    Route::get('all/not/admission', [AdmissionsController::class, 'showCompanyNotAdmission']);
    Route::post('admission/company/{id}', [AdmissionsController::class, 'admissionCompany']);
    Route::get('all/admission', [AdmissionsController::class, 'allAdmission']);
});


Route::middleware(['auth:sanctum', 'setapplang', 'companyControl'])->group(function () {
    Route::post('/product/addProduct/{id}', [ProductController::class, 'addProduct'])->middleware(['admin', 'admission']);
});
Route::get('/product/showProduct/{id}', [ProductController::class, 'showProduct'])->middleware(['auth:sanctum', 'setapplang']);
Route::get('/product/allProduct', [ProductController::class, 'allProduct'])->middleware(['auth:sanctum', 'setapplang']);
Route::post('/product/editProduct/{id}', [ProductController::class, 'editProduct'])->middleware(['auth:sanctum', 'setapplang', 'admin']);
Route::get('/product/deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->middleware(['auth:sanctum', 'setapplang', 'admin']);


Route::middleware(['auth:sanctum', 'setapplang'])->group(function () {
    Route::get('/followCompany/{id}', [FollowersController::class, 'addFollow'])->name('followerCompany');
    Route::get('/userIsFollowing', [FollowersController::class, 'userIsFollowing'])->name('userIsFollowing');
    Route::get('/companyFollowers/{id}', [FollowersController::class, 'companyFollowers'])->name('companyFollowers');
    Route::get('/unFollow/{id}', [FollowersController::class, 'unFollow'])->name('unFollow');
});

Route::middleware(['auth:sanctum', 'setapplang'])->group(function () {
    Route::post('addComment/{id}', [CommentsController::class, 'addComment'])->name('addComment');
    Route::get('allcomment/{id}', [CommentsController::class, 'allcomment'])->name('allcomment');
    Route::get('deleteComment/{idComment}', [CommentsController::class, 'deleteComment'])->name('deleteComment');
});

Route::middleware(['auth:sanctum', 'setapplang'])->group(function () {
    Route::get('addFavourite/{id}', [FavouriteController::class, 'addFavourite'])->name('addFavourite');
    Route::get('allFavouriteForUser', [FavouriteController::class, 'allFavouriteForUser'])->name('allFavouriteForUser');
    Route::get('allFavouriteForProduct/{id}', [FavouriteController::class, 'allFavouriteForProduct'])->name('allFavouriteForProduct');
});
