<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use App\UsersTrait as UsersTrait;

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

        $response = \API::post('users/register', [], $params);

        if ($response["code"] == "201") {

            return redirect('/admin/users')->with('success', 'User ' . $response["data"]->username . ' has been created');
            
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

        $response = \API::get('users/profile/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $user = $response['code'] == 200 ? $response['data'] : false;
        $name = ["",""];
        if ($user) {
            if (!empty($user->display_name)) {
                $parts = explode(" ", $user->display_name);
                $name[0] = isset($parts[0]) ? $parts[0]: "";
                $name[1] = isset($parts[1]) ? $parts[1]: "";
            }
        }
        
        return $user ? \View::make('admin/users/profile')
                        ->with('page_title', 'Profile')
                        ->with('user', $user)
                        ->with('avatar', UsersTrait::getAvatar($user))
                        ->with('name', $name) : abort(404);
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
        $rolesArray = [];
        $name = ["",""];
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
        } else {
            abort($response['code']);
        }

        $avatar = UsersTrait::getAvatar($user);

        return \View::make('admin/users/edit')
                        ->with('user', $user)
                        ->with('avatar', $avatar)
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

        if($request->session()->get('user_id') != $id)
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
        ];

        if (empty(Input::get('password'))) {
            unset($params['password']);
            unset($params['old_password']);
        }

        $response = \API::post('users/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $client = UsersTrait::getClientId($response['data']->id);
  
            if ($client) {

                $response['data']->client_id = $client;
                
                \Redis::publish('user-update', json_encode($response["data"]));
            }

            $message = 'User ' . $response["data"]->username . ' has been updated';

            return $request->session()->get('user_id') == "1" ?  redirect('/admin/users')->with('success', $message) : redirect()->back()->with('success', $message);
            
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

        if ($id == "1")
            return redirect('/admin/users')->with('errors', ['Sorry , but this user is untouchable :D']);

        $response = \API::post('users/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);

        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'User ' . $response['data']->username . ' banned successfuly');
            
            
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    /**
     * Remove the specified resource permenanetly from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id, Request $request) {

        \Policy::check('manage_users')->handle();

        if ($id == "1")
            return redirect('/admin/users')->with('errors', ['Sorry , but this user is untouchable :D']);

        $response = \API::post('users/force-delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);

        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'User ' . $response['data']->username . ' deleted permenanetly with success');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    /**
     * Remove the specified resource permenanetly from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id, Request $request) {

        \Policy::check('manage_users')->handle();

        if ($id == "1")
            return redirect('/admin/users')->with('errors', ['Sorry , but this user is untouchable :D']);

        $response = \API::post('users/restore/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], [ 'ID' => $request->session()->get('user_id')]);

        if ($response["code"] == "200") {

            return redirect('admin/users')->with('success', 'User ' . $response['data']->username . ' has been restored ');
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
        \Cookie::queue(\Cookie::forget('laravel_remember'));
        return redirect('/login');
        
    }

    public function processLogin(Request $request) {

        $username = Input::get('username');
        $password = Input::get('password');
        $remember = Input::get('remember');

        $response = \API::post('users/authenticate', [], ['username' => $username, 'password' => $password]);

        if ($response['code'] == 200) {

            UsersTrait::flushSession((array) $response['data']);

            $remem = false;

            if ($remember) {
                $remem = UsersTrait::remember((array) $response['data']);
            }


            \Redis::publish('user-login', json_encode((array) $response['data']));

            return $remem ? redirect('/admin/')->withCookie(cookie()->forever('laravel_remember', $remem)) : redirect('/admin/');
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

    public function search(Request $request) {

        return
                (array)
                \API::get('users/search', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id'), 'keyword' =>  Input::get('q')])
                )['data'];
        
    }

    public function uploadAvatar($id, Request $request) {

        \API::multipart('users/avatar', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id'), 'user_id' => $id, 'avatar' => Input::file('avatar')]);
       
    }

    public function saveClient() {

          UsersTrait::saveClient();
    }

    public function trashed(Request $request) {

        \Policy::check('manage_users')->handle();

        $response = \API::get('roles', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $roles = $response['code'] == 200 ? $response["data"] : [];

        return \View::make('admin/users/trashed')
                        ->with('roles', $roles)
                        ->with('page_title', 'Trashed Users List');
    }

    public function trashedDataTables(Request $request) {

        return
                (array)
                \API::get('users/dataTables/trashed', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

    public function forgetPassword() {
        return (array)
                \API::post('users/forget-password', [], ['email' => Input::get('email')]
                )['data'];
    }

    public function resetPassword() {

        return \View::make('admin/reset-password');
    }

    public function processForgetPassword(Request $request) {

        $response = (array)
                \API::get('users/reset-password', [], ['email' =>  Input::get('email'), 'token' => Input::get('token'), 'password' => Input::get('password'), 'password_confirmation' =>  Input::get('password_confirmation')]
        );

        if ($response["code"] == 200) {

            UsersTrait::flushSession((array) $response['data']);

            return redirect('/admin/')->with('success', 'You have successfuly reset your password');
            
        } else {

            return redirect()->back()->with('errors', $response["data"]->messages);
        }
    }

    /*
     * Social Part
     * 
     */

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider() {

        return \Socialite::driver('facebook')->scopes(['email', 'public_profile'])->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request) {

        if (Input::get('error') != NULL && Input::get('error') == "access_denied") {
            
            return redirect('/login')->with('erros', ['You have deauthorized facebook']);
            
        }

        $user = \Socialite::driver('facebook')->user();

        $avatar = preg_replace("/\?width=[0-9]*/", "?width=160", $user->avatar_original);


        $params = [
            'display_name' => $user->name,
            'avatar' => $avatar,
            'email' => $user->email
        ];

        $response = \API::post('users/facebook-connect', [], $params);

        if ($response['code'] == 200) {

            UsersTrait::flushSession((array) $response['data']);

            return redirect('/admin/')->with('success', 'Welcome To Artisan');
            
        } else {

            return redirect('/login')->with('errors', $response['data']->messages);
        }
    }
    
    public function flushSession() {
        
        UsersTrait::flushSession(Input::all());
        
    }

}