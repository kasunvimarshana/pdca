<?php

namespace App\Http\Controllers;

use App\UserAttachment;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use DB;
use \Response;
use Storage;

use App\Login;
use App\User;

class UserAttachmentController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserAttachment  $userAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(UserAttachment $userAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserAttachment  $userAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAttachment $userAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserAttachment  $userAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAttachment $userAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserAttachment  $userAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAttachment $userAttachment)
    {
        //
    }
    
    public function listUserAttachmentFileInput(Request $request){
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
        
        $initialPreview = array();
        $initialPreviewConfig = array();
        //$recordsTotal = Model::where('active','=','1')->count();
        
        $draw = $request->get('draw');
        
        $userAttachment = new UserAttachment();
        
        $query = $userAttachment->where('is_visible', '=', true);
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
                $query = $query->where('file_original_name', 'like', '%' . $search . '%');
            }
        }
        
        // attachable_type
        if( ($request->get('attachable_type')) && (!empty($request->get('attachable_type'))) ){
            $attachable_type = $request->get('attachable_type');
            $attachable_type = urldecode( $attachable_type );
            $query = $query->where('attachable_type', '=', $attachable_type);
        }
        
        // attachable_id
        if( ($request->get('attachable_id')) && (!empty($request->get('attachable_id'))) ){
            $attachable_id =  $request->get('attachable_id');
            $attachable_id = urldecode( $attachable_id );
            $query = $query->where('attachable_id', '=', $attachable_id);
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
        
        foreach($queryResult as $key => &$value){
            if(Storage::exists($value->link_url)){
                array_push($initialPreview, Storage::url($value->link_url));
                //array_push($initialPreview, asset($value->link_url));
                array_push($initialPreviewConfig, array(
                    'key' => $value->id, // keys for deleting/reorganizing preview
                    'caption' => $value->file_original_name,
                    'size' => Storage::size($value->link_url),
                    //'type' => Storage::mimeType($value->link_url),
                    'fileId' => $value->id, // file identifier
                    'zoomData' => Storage::url($value->link_url),
                    //'lastModified' => Storage::lastModified($value->link_url),
                    //'getVisibility' => Storage::getVisibility($value->link_url),
                    //'getMetaData' => Storage::getMetaData($value->link_url),
                    //'downloadUrl' => Storage::download($value->link_url, $value->file_original_name), // the url to download the file
                    //'url' => route('home', ['id' => 1]) // server api to delete the file based on key
                ));
            }
        }
        
        $recordsTotal = $recordsFiltered;
        $data = array(
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
            'initialPreviewAsData' => true
        );
        
        return Response::json( $data );   
    }
    
}
