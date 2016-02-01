<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class PermissionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_users')->handle();

        return \View::make('admin/permissions/all')
                        ->with('page_title', 'Permissions List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        \Policy::check('manage_users')->handle();
        $response = \API::get('roles', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'noAdmin' => true]);
        $roles = $response['code'] == 200 ? $response["data"] : [];

        return \View::make('admin/permissions/create')
                        ->with('page_title', 'Create Permission')
                        ->with('roles', $roles);
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
            'roles' => Input::get('roles')
        ];

        $response = \API::post('permissions/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/permissions')->with('success', $response["data"]->label . ' has been created');
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


        $response = \API::get('permissions/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $permission = $response["code"] == "200" ? $response["data"] : new \stdClass();

        $permissionRoles = [];
        if ($response['code'] == 200) {
            if (!empty($permission->role)) {
                foreach ($permission->role as $role) {
                    $permissionRoles[] = $role->id;
                }
            }
        }

        $responseRoles = \API::get('roles', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'noAdmin' => true]);
        $roles = $responseRoles['code'] == 200 ? $responseRoles["data"] : [];

        return \View::make('admin/permissions/edit')
                        ->with('permission', $permission)
                        ->with('roles', $roles)
                        ->with('permissionRoles', $permissionRoles)
                        ->with('page_title', 'Update Permission');
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
            'roles' => Input::get('roles')
        ];

        $response = \API::post('permissions/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "permission " . $response["data"]->label . ' has been updated';

            return redirect('/admin/permissions')->with('message', $message);
        } else {

            $errors = is_object($response['data']) ? $response['data']->messages : [$response['data']['phrase']];
            return redirect()->back()->with('errors', $errors);
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
        if ($id == "1")
            return redirect('/admin/permissions')->with('errors', ['Sorry , but this permission is untouchable :D']);

        $response = \API::post('permissions/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'permission deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function dataTables(Request $request) {

        return
                (array)
                \API::get('permissions/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
