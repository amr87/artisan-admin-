<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;


class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
         \Policy::check('manage_users')->handle();
       
        $response = \API::get('roles', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $roles = $response['code'] == 200 ? $response["data"] : [];
        return \View::make('admin/users/all')
                        ->with('roles', $roles)
                        ->with('page_title', 'Users List');
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

    public function login() {

        return \View::make('admin/login');
    }

    public function logout(Request $request) {
    
        $request->session()->forget('user_id');
        $request->session()->forget('user_data');
        return redirect('/login');
        
    }

    public function processLogin(Request $request) {

        $username = Input::get('username');
        $password = Input::get('password');
        $response = \API::post('users/authenticate', [], ['username' => $username, 'password' => $password]);

        if ($response['code'] == 200) {
            $user = (array) $response['data'];

            $avatar = $user['social'] == "0" ? getenv('API_BASE').$user['avatar'] : $user['avatar'];
            $request->session()->put('user_id', $user['id']);
            $request->session()->put('user_data', [
                'auth'         => $user['token'],
                'roles'        => $user['roles'],
                'name'         => $user['display_name'],
                'bio'          => $user['bio'],
                'avatar'       => $avatar,
                'member_since' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$user['created_at'])->format('M. Y'),
            ]);

            return redirect('/admin/');
        } else {
          return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function dataTables(Request $request) {
        return
                (array)
                \API::get('users/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
