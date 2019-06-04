<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use LdapQuery\Builder; 
use Carbon\Carbon;
use DB;
use App\User;
use \Response;
use App\LDAPModel;
use App\Login;


class UserController extends Controller
{
    //other
    public function listUsers(Request $request){
        // Solution to get around integer overflow errors
        // $model->latest()->limit(PHP_INT_MAX)->offset(1)->get();
        // function will process the ajax request
        $draw = null;
        $start = 0;
        $length = 0;
        $search = null;
        
        $recordsTotal = 0;
        $recordsFiltered = 0;
        $query = null;
        $queryResult = null;
        //$recordsTotal = Model::where('active','=','1')->count();
        
        $draw = $request->get('draw');
        
        $user = new User();
        $ldapModel = new LDAPModel();
        $query = new Builder();
        //$ldapModel->setOption(LDAP_OPT_SIZELIMIT, 1000);
            
        // get search query value
        if( ($request->get('search')) && (!empty($request->get('search'))) ){
            $search = $request->get('search');
            if( $search && (@key_exists('value', $search)) ){
                $search = $search['value'];
            }
            if($search && (!empty($search))){
                //$search = (string) $search;
                $query = $query->whereRaw('mail', '=', $search . '*');
            }
        }
        
        // employeenumber
        if( ($request->get('employeenumber')) && (!empty($request->get('employeenumber'))) ){
            $employeenumber = urldecode($request->get('employeenumber'));
            $query = $query->whereRaw('employeenumber', '=', $employeenumber);
        }
        
        // cn
        if( ($request->get('cn')) && (!empty($request->get('cn'))) ){
            $cn =  urldecode($request->get('cn'));
            $query = $query->whereRaw('cn', '=', '*' . $cn . '*');
        }
        
        // department
        if( ($request->get('department')) && (!empty($request->get('department'))) ){
            $department = urldecode($request->get('department'));
            $query = $query->whereRaw('department', '=', $department);
        }
        
        // mobile
        if( ($request->get('mobile')) && (!empty($request->get('mobile'))) ){
            $mobile = urldecode($request->get('mobile'));
            $query = $query->whereRaw('mobile', '=', $mobile);
        }
        
        // get data
        $queryResult = (array) $user->findUsers( $query->stringify() );
        $recordsFiltered = count($queryResult, 0);
        
        $recordsTotal = $recordsFiltered;
        $data = array(
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $queryResult
        );
        
        return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        //return Response::json( $data );
    }
}
