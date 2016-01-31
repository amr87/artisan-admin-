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
    public function create(Request $request) {

        \Policy::check('manage_users')->handle();

        $response = \API::get('roles', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'noAdmin' => true]);
        $roles = $response['code'] == 200 ? $response["data"] : [];
        return \View::make('admin/users/create')
                        ->with('roles', $roles)
                        ->with('page_title', 'Create User');
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
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
            'phone' => Input::get('phone'),
            'bio' => Input::get('bio'),
            'role' => Input::get('role'),
            'avatar' => Input::file('avatar'),
        ];

        $response = \API::post('users/register',[], $params);

        if ($response["code"] == "201") {

            return redirect('/admin/users')->with('success', $response["data"]->username . ' has been created');
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

        $responseRoles = \API::get('roles', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'noAdmin' => true]);
        $roles = $responseRoles['code'] == 200 ? $responseRoles["data"] : [];
        $response = \API::get('users/profile/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $user = $response["code"] == "200" ? $response["data"] : new \stdClass();
        $name = $rolesArray = [];
        if ($response['code'] == 200) {
            if (!empty($user->display_name)) {
                $parts = @explode(" ", $user->display_name);
                $name = [@$parts[0], @$parts[1]];
            }
            if (!empty($user->roles)) {
                foreach ($user->roles as $role) {
                    $rolesArray[] = $role->id;
                }
            }
        } elseif ($response['code'] == 401) {
            abort(401);
        }

        return \View::make('admin/users/edit')
                        ->with('user', $user)
                        ->with('name', $name)
                        ->with('rolesArray', $rolesArray)
                        ->with('roles', $roles)
                        ->with('page_title', 'Update User');
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

        \Policy::check('manage_users')->handle();

        $params = [
            'ID' => $request->session()->get('user_id'),
            '_method' => 'PUT',
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'old_password' => Input::get('old_password'),
            'phone' => Input::get('phone'),
            'bio' => Input::get('bio'),
            'role' => Input::get('role'),
            'avatar' => Input::file('avatar'),
        ];

        if (empty(Input::get('password'))) {
            unset($params['password']);
            unset($params['old_password']);
        }

        $response = \API::post('users/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = $response["data"]->username . ' has been updated';
            return redirect('/admin/users')->with('message', $message);
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
            return redirect('/admin/users')->with('errors', ['Sorry , but this user is untouchable :D']);
        $response = \API::post('users/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {
            return redirect()->back()->with('success', 'user deleted successfuly');
        } else {
            return redirect()->back()->with('errors', $response['data']->messages);
        }
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

            $avatar = $user['social'] == "0" ? getenv('API_BASE') . str_replace(".jpg", "-160.jpg", $user['avatar']) : $user['avatar'];
            $request->session()->put('user_id', $user['id']);
            $request->session()->put('user_data', [
                'auth' => $user['token'],
                'roles' => $user['roles'],
                'name' => $user['display_name'],
                'bio' => $user['bio'],
                'avatar' => $avatar,
                'member_since' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user['created_at'])->format('M. Y'),
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

    public function uploadAvatar($id, Request $request) {

        $response = \API::multipart('users/avatar', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'user_id' => $id, 'avatar' => Input::file('avatar')]);
    }

}
