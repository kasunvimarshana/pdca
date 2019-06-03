<?php

namespace App\Http\Controllers;

use App\PDCAUser;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use DB;
use \Response;

use App\Login;
use App\User;

class PDCAUserController extends Controller
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
     * @param  \App\PDCAUser  $pDCAUser
     * @return \Illuminate\Http\Response
     */
    public function show(PDCAUser $pDCAUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PDCAUser  $pDCAUser
     * @return \Illuminate\Http\Response
     */
    public function edit(PDCAUser $pDCAUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PDCAUser  $pDCAUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PDCAUser $pDCAUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PDCAUser  $pDCAUser
     * @return \Illuminate\Http\Response
     */
    /*public function destroy(PDCAUser $pDCAUser)
    {
        $pDCAUserClone = clone $pDCAUser;
    }*/
    public function destroy(Request $request, $pDCAUser)
    {
        //
        $data = array('title' => '', 'text' => '', 'type' => '', 'timer' => 3000);
        //Model::find(explode(',', $id))->delete();
        // do process
        // Start transaction!
        DB::beginTransaction();

        try {
            $pDCAUserObj = new PDCAUser();
            $pDCAUserObj->where('own_user', '=', urldecode($pDCAUser))
                ->where('p_d_c_a_id', '=', urldecode($request->get('p_d_c_a_id')))
                ->delete();
            
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
}
