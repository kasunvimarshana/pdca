<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', array('uses' => 'LoginController@showLogin'))->name('home');
// route to show the login form
Route::get('login', array('uses' => 'LoginController@showLogin'))->name('login.showLogin');
// route to process the form
Route::post('login', array('uses' => 'LoginController@doLogin'))->name('login.doLogin');
// route to procss logout
Route::get('logout', array('uses' => 'LoginController@doLogout'))->name('login.doLogout');

Route::get('home', array('uses' => function(){
    return view('home');
}))->name('home.index');

Route::group(['middleware' => 'memberMiddleWare'], function(){
    Route::match(['get', 'post'], 'users/list', array('uses' => 'UserController@listUsers'))->name('user.list');
    Route::match(['get', 'post'], 'companies/list', array('uses' => 'CompanyController@listCompanies'))->name('company.list');
    Route::match(['get', 'post'], 'departments/list', array('uses' => 'DepartmentController@listDepartments'))->name('department.list');
    
    Route::get('pdcas/create', array('uses' => 'PDCAController@create'))->name('pDCA.create');
    Route::post('pdcas/create', array('uses' => 'PDCAController@store'))->name('pDCA.store');
});

Route::group(['middleware' => 'superAdminMiddleware'], function(){
    Route::get('backstage/user-roles/create', array('uses' => 'UserRoleController@create'))->name('userRole.create');
    Route::post('backstage/user-roles/create', array('uses' => 'UserRoleController@store'))->name('userRole.store');
    Route::match(['get', 'post'], 'user-roles/list', array('uses' => 'UserRoleController@listUserRoles'))->name('userRole.list');
    Route::get('backstage/user-roles/{userRole}/destroy', array('uses' => 'UserRoleController@destroy'))->name('userRole.destroy');
    
    Route::get('backstage/companies/create', array('uses' => 'CompanyController@create'))->name('company.create');
    Route::post('backstage/companies/create', array('uses' => 'CompanyController@store'))->name('company.store');
    Route::get('backstage/companies/{company}/edit', array('uses' => 'CompanyController@edit'))->name('company.edit');
    Route::post('backstage/companies/{company}/update', array('uses' => 'CompanyController@update'))->name('company.update');
    
    Route::get('backstage/departments/create', array('uses' => 'DepartmentController@create'))->name('department.create');
    Route::post('backstage/departments/create', array('uses' => 'DepartmentController@store'))->name('department.store');
    Route::get('backstage/departments/{department}/edit', array('uses' => 'DepartmentController@edit'))->name('department.edit');
    Route::post('backstage/departments/{department}/update', array('uses' => 'DepartmentController@update'))->name('department.update');
});
