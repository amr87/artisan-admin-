<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class RolesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_users')->handle();

        return \View::make('admin/roles/all')
                        ->with('page_title', 'Roles List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        \Policy::check('manage_users')->handle();

        $response = \API::get('permissions', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'noAdmin' => true]);

        $permissions = $response['code'] == 200 ? $response["data"] : [];
        return \View::make('admin/roles/create')
                        ->with('permissions', $permissions)
                        ->with('page_title', 'Create Role');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        \Policy::check('manage_users')->handle();

        $params = [
            'ID' => $request->session()->get('user_id'),
            'name' => Input::get('name'),
            'permissions' => Input::get('permissions'),
            'users' => Input::get('users'),
        ];

        $response = \API::post('roles/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/roles')->with('success', "Role " . $response["data"]->label . ' has been created');
        } else {

            return redirect()->back()->withInput()->with('errors', $response['data']->messages);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request) {

        \Policy::check('manage_users')->handle();

        $responsePermissions = \API::get('permissions', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'noAdmin' => true]);
        $permissions = $responsePermissions['code'] == 200 ? $responsePermissions["data"] : [];
        $response = \API::get('roles/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $role = $response["code"] == "200" ? $response["data"] : new \stdClass();

        $permissionIds = $usersIds = [];

        if ($response['code'] == 200) {

            if ($role->permissions) {
                foreach ($role->permissions as $permission) {
                    $permissionIds[] = $permission->id;
                }
            }
            if ($role->user) {
                foreach ($role->user as $user) {
                    $usersIds[] = $user->id;
                }
            }
        }


        return \View::make('admin/roles/edit')
                        ->with('role', $role)
                        ->with('permissions', $permissions)
                        ->with('permissionIds', $permissionIds)
                        ->with('usersIds', $usersIds)
                        ->with('page_title', 'Update Role');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        \Policy::check('manage_users')->handle();

        $params = [
            'ID' => $request->session()->get('user_id'),
            '_method' => 'PUT',
            'name' => Input::get('name'),
            'permissions' => Input::get('permissions'),
            'users' => Input::get('users'),
        ];

        $response = \API::post('roles/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "Role " . $response["data"]->label . ' has been updated';

            return redirect('/admin/roles')->with('success', $message);
        } else {

  
            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {

        \Policy::check('manage_users')->handle();

        if ($id == "1" || $id == "2")
            return redirect('/admin/roles')->with('errors', ['Sorry , but this role is untouchable :D']);

        $response = \API::post('roles/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'Role ' . $response['data']->label . ' deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function dataTables(Request $request) {

        return
                (array)
                \API::get('roles/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
