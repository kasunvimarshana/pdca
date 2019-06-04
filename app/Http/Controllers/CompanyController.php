<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Str;
use App\LDAPModel;
use LdapQuery\Builder; 
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use \StdClass;
use \Response;

use App\Login;
use App\User;
use App\PDCA;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(view()->exists('company_create')){
            return View::make('company_create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = array('title' => '', 'text' => '', 'type' => '', 'timer' => 3000);
        // do process
        $current_user = Login::getUserData()->mail;

        $companyData = array(	
            'is_visible' => true,
            'name' => urldecode(Input::get('name'))
        );

        // Start transaction!
        DB::beginTransaction();

        try {
            // Validate, then create if valid
            $newCompany = Company::create( $companyData );

        }catch(\Exception $e){

            DB::rollback();

            $data = array(
                'title' => 'error',
                'text' => 'error',
                'type' => 'warning',
                'timer' => 3000
            );

            return Response::json( $data ); 

        }

        DB::commit();
        
        $data = array(
            'title' => 'success',
            'text' => 'success',
            'type' => 'success',
            'timer' => 3000
        );
        
        return Response::json( $data );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
        if(view()->exists('company_edit')){
            return View::make('company_edit', ['company' => $company]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
        $companyClone = clone $company;
        $data = array('title' => '', 'text' => '', 'type' => '', 'timer' => 3000);
        // do process
        $current_user = Login::getUserData()->mail;

        $companyData = array(
            'name' => urldecode(Input::get('name'))
        );

        // Start transaction!
        DB::beginTransaction();

        try {
            // Validate, then create if valid
            $companyClone->update( $companyData );

        }catch(\Exception $e){

            DB::rollback();
            $data = array(
                'title' => 'error',
                'text' => 'error',
                'type' => 'warning',
                'timer' => 3000
            );

            return redirect()->back()->withInput();

        }

        DB::commit();
        
        $data = array(
            'title' => 'success',
            'text' => 'success',
            'type' => 'success',
            'timer' => 3000
        );
        
        notify()->flash(
            $data['title'], 
            $data['type'], [
            'timer' => $data['timer'],
            'text' => $data['text'],
        ]);
        
        return redirect()->route('company.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
    
    //other
    public function listCompanies(Request $request){
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
        
        $company = new Company();
        
        $query = $company->where('is_visible', '=', true);
        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;
            
        // get search query value
        if( ($request->get('search')) && (!empty($request->get('search'))) ){
            $search = $request->get('search');
            if( $search && (@key_exists('value', $search)) ){
                $search = $search['value'];
            }
            if($search && (!empty($search))){
                //$search = (string) $search;
                $query = $query->where('name', 'like', '%' . $search . '%');
            }
        }
        
        // get filtered record count
        $recordsFiltered = $query->count();
        
        // get limit value
        if( $request->get('length') ){
            $length = intval( $request->get('length') );
            $query = $query->limit($length);
        }
        // set default value for length (PHP_INT_MAX)
        if( $length <= 0 ){
            $length = PHP_INT_MAX;
            //$length = 0;
        }
        
        // get offset value
        if( $request->get('start') ){
            $start = intval( $request->get('start') );
        }else if( $request->get('page') ){
            $start = intval( $request->get('page') );
            //$start = abs( ( ( $start - 1 ) * $length ) );
            $start = ( ( $start - 1 ) * $length );
        }
        
        // filter with offset value
        if( $start > 0 ){
            //$query = $query->limit($length)->skip($start);
            $query = $query->limit($length)->offset($start);
        }
        
        // order
        $query->orderBy('id', 'desc');
        $query->orderBy('updated_at', 'desc');
        
        // get data
        $queryResult = $query->get();
        
        $recordsTotal = $recordsFiltered;
        $data = array(
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $queryResult,
        );
        
        return Response::json( $data );   
    }
    
    public function showDepartments(Request $request){
        $loginUser = Login::getUserData();
        $date_today = Carbon::now()->format('Y-m-d');
        $date_from = Carbon::now()->startOfYear()->format('Y-m-d');
        $date_to = Carbon::now()->format('Y-m-d');
        $complete_date_from = $date_from;
        $complete_date_to = $date_to;
        
        $companyObj = new StdClass();
        $companyObj->company_name = $loginUser->company;
        $departmentsArray = array();
        
        $departmentsArray = DB::table('p_d_c_a_company_departments')
            ->select('company_pk')
            ->addSelect('department_pk')
            ->where('is_visible', true)
            ->where('company_pk','=',$companyObj->company_name)
            ->distinct('department_pk')
            ->get();
        
        foreach($departmentsArray as $key=>&$value){
            
            $pDCAAllCount = PDCA::where('is_visible','=',true)
                ->whereDate('complete_date','>=',$complete_date_from)
                ->whereDate('complete_date','<=',$complete_date_to)
                ->count();

            $pDCACompanyDepartmentAllCount = PDCA::where('is_visible','=',true)
                ->whereDate('complete_date','>=',$complete_date_from)
                ->whereDate('complete_date','<=',$complete_date_to)
                ->whereHas('pDCACompanyDepartments', function($query) use ($value){
                    $query->where('company_pk','=',$value->company_pk);
                    $query->where('department_pk','=',$value->department_pk);
                    $query->distinct('id');
                })
                ->count();

            if( ($pDCAAllCount == 0) || empty($pDCAAllCount) ){
                $pDCAAllCount = 1;
            }
            
            $value->pDCAAllCount = $pDCAAllCount;
            $value->pDCACompanyDepartmentAllCount = $pDCACompanyDepartmentAllCount;
            $value->pDCACompanyDepartmentAllCountPercentage = (($pDCACompanyDepartmentAllCount / $pDCAAllCount) * 100);

        }
        
        // get data
        $companyObj->departments = $departmentsArray;
        
        if(view()->exists('company_department_show')){
            return View::make('company_department_show', ['companyObj' => $companyObj]);
        }
    }
    
}
