<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use App\PaginatorTrait as Paging;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $page = Input::get('page');
        $page = is_null($page) ? 1 : $page;
        $params = ['ID' => '1','page' => $page];
        $headers = ['Authorization' => '$2y$10$XPJcN3w4yDVI45sUsOVbT.t7qXStvJ542ATAbUY.oCC4/CxBhObHm'];
        $response = \API::get("users", $headers, $params);
       
        $error = $response['code'] != 200 ? true : false;
        
        $data = !$error ? $response["data"] : $response["data"]->messages;
        
        $paginator = !$error ? Paging::getPaginator($response["data"]): "";
        
        return \View::make('admin/users/all')
                 ->with('page_title','Users List')
                 ->with('data',$data)
                 ->with('paginator',$paginator)
                 ->with('error',$error);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
