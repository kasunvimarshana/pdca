<?php

namespace App\Http\Controllers;

use App\PDCA;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use DB;
use \Response;
use Storage;
use Carbon\Carbon;
use Chumper\Zipper\Zipper;

use App\Login;
use App\User;
use App\Enums\PDCAStatusEnum;
use App\Enums\PDCAMetaEnum;
use App\PDCAUser;
use App\PDCAInfo;
use App\UserAttachment;
use App\PDCACompanyDepartment;

class PDCAController extends Controller
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
        if(view()->exists('pdca_create')){
            return View::make('pdca_create');
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
        /*DB::transaction(function () {
            DB::table('table_1')->update(['column' => 1]);
            DB::table('table_2')->delete();
        });*/
        // validate the info, create rules for the inputs
        $rules = array(
            'title'    => 'required',
            'company_pk'    => 'required',
            'department_pk'    => 'required'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            
            $data = array(
                'title' => 'error',
                'text' => 'error',
                'type' => 'warning',
                'timer' => 3000
            );

            return Response::json( $data ); 
            
        } else {
            // do process
            $loginUserObj = Login::getUserData();
            $current_user = $loginUserObj->mail;
            $company_name = $loginUserObj->company;
            $department_name = $loginUserObj->department;
            $pDCAResourceDir = PDCAMetaEnum::RESOURCE_DIR .'/'. uniqid( time() ) . '_';
            
            $pDCAData = array(	
                //'is_visible' => true,
                'created_user' => $current_user,
                'company_name' => $company_name,
                'department_name' => $department_name,
                'title' => Input::get('title'),
                'description' => Input::get('description'),
                'p_d_c_a_category_id' => Input::get('p_d_c_a_category_id'),
                'status_id' => PDCAStatusEnum::DEFAULT,
                'start_date' => Input::get('start_date'),
                'complete_date' => Input::get('complete_date'),
                'piority' => Input::get('piority'),
                'resource_dir' => $pDCAResourceDir
            );
            
            $pDCAUserData = (array) Input::get('own_user');
            $userAttachmentData = (array) $request->file('var_user_attachment');
            $company_pkData = Input::get('company_pk');
            $department_pkData = Input::get('department_pk');
            
            // Start transaction!
            DB::beginTransaction();

            try {
                //create directory
                if(!Storage::exists($pDCAResourceDir)) {
                    Storage::makeDirectory($pDCAResourceDir, 0775, true); //creates directory
                }
                // Validate, then create if valid
                $newPDCA = PDCA::create( $pDCAData );
                
                $newPDCAInfo = PDCAInfo::create(array(
                    'is_visible' => true,
                    'p_d_c_a_id' => $newPDCA->id,
                    'description' => $newPDCA->description,
                    'created_user' => $current_user
                ));
                
                $newPDCACompanyDepartment = PDCACompanyDepartment::create(array(
                    'is_visible' => true,
                    'p_d_c_a_id' => $newPDCA->id,
                    'company_pk' => $company_pkData,
                    'department_pk' => $department_pkData
                ));
                
                foreach($pDCAUserData as $key => $value){
                    $tempUser = new User();
                    $tempUser->mail = $value;
                    $tempUser = $tempUser->getUser();
                    
                    $newPDCAUser = PDCAUser::create(array(
                        'is_visible' => true,
                        'p_d_c_a_id' => $newPDCA->id,
                        'own_user' => $tempUser->mail,
                        'company_name' => $tempUser->company,
                        'department_name' => $tempUser->department
                    ));
                }
                
                if( $request->hasFile('var_user_attachment') ){
                    foreach($userAttachmentData as $key => $value){
                        $file_original_name = $value->getClientOriginalName();
                        $file_type = $value->getClientOriginalExtension();
                        //$filename = $value->store( $pDCAResourceDir );
                        $filename = $value->storeAs( 
                            $pDCAResourceDir,
                            $newPDCA->id . '_' . uniqid( time() ) . '_' . $file_original_name
                        );
                        $newUserAttachment = $newPDCA->userAttachments()->create(array(
                            'is_visible' => true,
                            'attached_by' => $current_user,
                            'file_original_name' => $file_original_name,
                            //'attachable_type' => get_class( $object ),
                            //'attachable_id' => $object->id,
                            'file_type' => $file_type,
                            'link_url' => $filename
                        ));
                    }
                }
                
            }catch(\Exception $e){
                
                DB::rollback();
                
                //delete directory
                if(Storage::exists($pDCAResourceDir)) {
                    Storage::deleteDirectory($pDCAResourceDir);
                }
                
                $data = array(
                    'title' => 'error',
                    'text' => 'error',
                    'type' => 'warning',
                    'timer' => 3000
                );

                return Response::json( $data ); 
                
            }

            // If we reach here, then
            // data is valid and working.
            // Commit the queries!
            DB::commit();
        }
        
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
     * @param  \App\PDCA  $pDCA
     * @return \Illuminate\Http\Response
     */
    public function show(PDCA $pDCA)
    {
        //
        if(view()->exists('pdca_show')){
            return View::make('pdca_show', array('pDCA' => $pDCA));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PDCA  $pDCA
     * @return \Illuminate\Http\Response
     */
    public function edit(PDCA $pDCA)
    {
        //
        if(view()->exists('pdca_edit')){
            return View::make('pdca_edit', array('pDCA' => $pDCA));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PDCA  $pDCA
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PDCA $pDCA)
    {
        //
        $pDCAClone = clone $pDCA;
        $data = array('title' => '', 'text' => '', 'type' => '', 'timer' => 3000);
        /*DB::transaction(function () {
            DB::table('table_1')->update(['column' => 1]);
            DB::table('table_2')->delete();
        });*/
        // validate the info, create rules for the inputs
        $rules = array(
            'title'    => 'required',
            'company_pk'    => 'required',
            'department_pk'    => 'required'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            
            $data = array(
                'title' => 'error',
                'text' => 'error',
                'type' => 'warning',
                'timer' => 3000
            );

            //return Response::json( $data );
            return redirect()->back()->withInput();
            
        } else {
            // do process
            $loginUserObj = Login::getUserData();
            $current_user = $loginUserObj->mail;
            $company_name = $loginUserObj->company;
            $department_name = $loginUserObj->department;
            //$pDCAResourceDir = PDCAMetaEnum::RESOURCE_DIR .'/'. uniqid( time() ) . '_';
            $pDCAResourceDir = $pDCAClone->resource_dir;
            if( (!isset($pDCAResourceDir)) || (empty($pDCAResourceDir)) ){
                $pDCAResourceDir = PDCAMetaEnum::RESOURCE_DIR .'/'. uniqid( time() ) . '_';
            }
            
            $pDCAData = array(	
                //'is_visible' => true,
                //'created_user' => $current_user,
                //'company_name' => $company_name,
                //'department_name' => $department_name,
                'title' => Input::get('title'),
                'description' => Input::get('description'),
                'p_d_c_a_category_id' => Input::get('p_d_c_a_category_id'),
                'status_id' => PDCAStatusEnum::DEFAULT,
                'start_date' => Input::get('start_date'),
                'complete_date' => Input::get('complete_date'),
                'piority' => Input::get('piority'),
                'resource_dir' => $pDCAResourceDir
            );
            
            $pDCAUserData = (array) Input::get('own_user');
            $userAttachmentData = (array) $request->file('var_user_attachment');
            $company_pkData = Input::get('company_pk');
            $department_pkData = Input::get('department_pk');
            
            // Start transaction!
            DB::beginTransaction();

            try {
                //create directory
                if(!Storage::exists($pDCAResourceDir)) {
                    Storage::makeDirectory($pDCAResourceDir, 0775, true); //creates directory
                }
                // Validate, then create if valid
                $pDCAClone->update( $pDCAData );
                
                $pDCAInfo = new PDCAInfo();
                $pDCAInfo->firstOrCreate(array(
                    'is_visible' => true,
                    'p_d_c_a_id' => $pDCAClone->id,
                    'description' => $pDCAClone->description,
                    'created_user' => $pDCAClone->created_user
                ));
                
                $pdcaCompanyDepartment = new PDCACompanyDepartment();
                $pdcaCompanyDepartment->firstOrCreate(array(
                    'is_visible' => true,
                    'p_d_c_a_id' => $pDCAClone->id,
                    'company_pk' => $company_pkData,
                    'department_pk' => $department_pkData
                ));
                
                foreach($pDCAUserData as $key => $value){
                    $tempUser = new User();
                    $tempUser->mail = $value;
                    $tempUser = $tempUser->getUser();
                    $tempPDCAUser = new PDCAUser();
                    
                    $savedPDCAUser = $tempPDCAUser->firstOrCreate(array(
                        'is_visible' => true,
                        'p_d_c_a_id' => $pDCAClone->id,
                        'own_user' => $tempUser->mail,
                        'company_name' => $tempUser->company,
                        'department_name' => $tempUser->department
                    ));
                }
                
                if( $request->hasFile('var_user_attachment') ){
                    foreach($userAttachmentData as $key => $value){
                        $file_original_name = $value->getClientOriginalName();
                        $file_type = $value->getClientOriginalExtension();
                        //$filename = $value->store( $pDCAResourceDir );
                        $filename = $value->storeAs( 
                            $pDCAResourceDir,
                            $pDCAClone->id . '_' . uniqid( time() ) . '_' . $file_original_name
                        );
                        $newUserAttachment = $pDCAClone->userAttachments()->create(array(
                            'is_visible' => true,
                            'attached_by' => $current_user,
                            'file_original_name' => $file_original_name,
                            //'attachable_type' => get_class( $object ),
                            //'attachable_id' => $object->id,
                            'file_type' => $file_type,
                            'link_url' => $filename
                        ));
                    }
                }
                
            }catch(\Exception $e){
                
                DB::rollback();
                
                //delete directory
                /*if(Storage::exists($pDCAResourceDir)) {
                    Storage::deleteDirectory($pDCAResourceDir);
                }*/
                
                $data = array(
                    'title' => 'error',
                    'text' => 'error',
                    'type' => 'warning',
                    'timer' => 3000
                );dd($e);

                //return Response::json( $data ); 
                return redirect()->back()->withInput();
                
            }

            // If we reach here, then
            // data is valid and working.
            // Commit the queries!
            DB::commit();
        }
        
        $data = array(
            'title' => 'success',
            'text' => 'success',
            'type' => 'success',
            'timer' => 3000
        );
        
        //return Response::json( $data );
        notify()->flash(
            $data['title'], 
            $data['type'], [
            'timer' => $data['timer'],
            'text' => $data['text'],
        ]);
        
        return redirect()->back()->withInput();
        //return redirect()->route('pDCA.showCreatedPDCA');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PDCA  $pDCA
     * @return \Illuminate\Http\Response
     */
    public function destroy(PDCA $pDCA)
    {
        //
        $pDCAClone = clone $pDCA;
        $data = array('title' => '', 'text' => '', 'type' => '', 'timer' => 3000);
        //Model::find(explode(',', $id))->delete();
        // do process
        // Start transaction!
        DB::beginTransaction();

        try {
            
            //delete directory
            if(Storage::exists($pDCAClone->resource_dir)) {
                Storage::deleteDirectory($pDCAClone->resource_dir);
            }
            
            $pDCAClone->userAttachments()->delete();
            $pDCAClone->pDCACompanyDepartments()->delete();
            $pDCAClone->pDCAUsers()->delete();
            $pDCAClone->delete();
            
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
    
    //
    public function listPDCAs(Request $request){
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
        $date_today = Carbon::now()->format('Y-m-d');
        
        $draw = $request->get('draw');
        
        $pDCA = new PDCA();
        
        $query = $pDCA->with(['userAttachments','pDCACompanyDepartments','pDCAUsers','status','pDCACategory','companies','departments'])->where('is_visible', '=', true);
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
                $query = $query->where('title', 'like', '%' . $search . '%');
            }
        }
        
        // own user
        if( ($request->get('own_user')) && (!empty($request->get('own_user'))) ){
            $own_user =  $request->get('own_user');
            $query = $query->whereHas('pDCAUsers', function($query) use ($own_user){
                $query->where('own_user', '=', $own_user);
            });
        }
        
        // company
        if( ($request->get('company_pk')) && (!empty($request->get('company_pk'))) ){
            $company_pk =  $request->get('company_pk');
            $query = $query->whereHas('pDCACompanyDepartments', function($query) use ($company_pk){
                $query->where('company_pk', '=', $company_pk);
            });
        }
        
        // department
        if( ($request->get('department_pk')) && (!empty($request->get('department_pk'))) ){
            $department_pk =  $request->get('department_pk');
            $query = $query->whereHas('pDCACompanyDepartments', function($query) use ($department_pk){
                $query->where('department_pk', '=', $department_pk);
            });
        }
        
        // category
        if( ($request->get('p_d_c_a_category_name')) && (!empty($request->get('p_d_c_a_category_name'))) ){
            $p_d_c_a_category_name =  $request->get('p_d_c_a_category_name');
            $query = $query->whereHas('pDCACategory', function($query) use ($p_d_c_a_category_name){
                $query->where('name', '=', $p_d_c_a_category_name);
            });
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
    
    public function showCreatedPDCA(Request $request){
        if(view()->exists('pdca_created_show_all')){
            return View::make('pdca_created_show_all');
        }
    }
    
    public function getFile(Request $request, PDCA $pDCA){
        $userAttachments = $pDCA->userAttachments;
        if( $userAttachments ){
            $pDCAResourceDir = PDCAMetaEnum::RESOURCE_DIR . '/' . 'tep_files';
            if(!Storage::exists($pDCAResourceDir)) {
                Storage::makeDirectory($pDCAResourceDir, 0775, true); //creates directory
            }
            $zipperName = $pDCAResourceDir . '/attachments.zip';
            
            $zipper = new Zipper();
            $zipper->make(Storage::path($zipperName))->folder('attachments');
            foreach($userAttachments as $userAttachment){
                if(Storage::exists( $userAttachment->link_url )) {
                    $zipper->add( Storage::path( $userAttachment->link_url ) );
                }
            }
            $zipper->close();
            
            if(Storage::exists($zipperName)) {
                //return response()->download( Storage::url( $zipperName ) );
                return Storage::download( $zipperName );
            }else{
                return redirect()->back();
            }
        } 
    }
}
