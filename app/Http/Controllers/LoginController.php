<?php

namespace App\Http\Controllers;

use App\Login;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
//use Auth;
use \Response;
use DB;
use App\Company;
use App\Department;

class LoginController extends Controller
{
    //private $loginObj;
    
    function __construct(){
        //$loginObj = new Login();
    }
    
    public function index(){}
    
    public function showLogin(){
        if( Login::isLogin() ){
            return redirect()->route('home.index');
        }else if(view()->exists('login')){
            return View::make('login');
        }
    }
    
    public function doLogin(){
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required',
            'password' => 'required|min:3'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if($validator->fails()){
            return redirect()->route('login.showLogin')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
        }else{
            $suffix = '@brandix.com';
            $email = urldecode(Input::get('email'));
            if( (!@stripos($email, $suffix)) ){
                $email = $email . $suffix;
            }
            $password = urldecode(Input::get('password'));
            // attempt to do the login
            Login::doLogin($email, $password);
            if( Login::isLogin() ){
                $loginUserObj = Login::getUserData();
                $loginUserObjCompany = $loginUserObj->company;
                $loginUserObjDepartment = $loginUserObj->department;
                $company = new Company();
                $department = new Department();
                DB::transaction(function() use ($company, $department, $loginUserObjCompany, $loginUserObjDepartment){
                    $company = $company->firstOrCreate(array('name' => $loginUserObjCompany));
                    $department = $department->firstOrCreate(array('name' => $loginUserObjDepartment));
                });
                
                return redirect()->route('home.index');
            }else{
                return redirect()->route('login.showLogin')->withInput(Input::except('password'));
            }
        }
        
    }
    
    public function doLogout(){
        Login::doLogout();
        //$exitCode = Artisan::call('cache:clear');
        return redirect()->route('login.showLogin');
    }
 
}
