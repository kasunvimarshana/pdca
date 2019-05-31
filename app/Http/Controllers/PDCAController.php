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
                    $tempPDCAUser = new User();
                    $tempPDCAUser->mail = $value;
                    $tempPDCAUser = $tempPDCAUser->getUser();
                    
                    $newPDCAUser = PDCAUser::create(array(
                        'is_visible' => true,
                        'p_d_c_a_id' => $newPDCA->id,
                        'own_user' => $tempPDCAUser->mail,
                        'company_name' => $tempPDCAUser->company,
                        'department_name' => $tempPDCAUser->department
                    ));
                }
                
                if( $request->hasFile('var_user_attachment') ){
                    foreach($userAttachmentData as $key => $value){
                        $file_original_name = $value->getClientOriginalName();
                        $file_type = $value->getClientOriginalExtension();
                        //$filename = $value->store( $pDCAResourceDir );
                        $filename = $value->storeAs( 
                            $pDCAResourceDir,
                            $newPDCA->id . '_' . $file_original_name
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
    }
}
