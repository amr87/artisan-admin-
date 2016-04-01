<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of UsersTrait
 *
 * @author amr
 */
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input as Input;
use App\User as User;

trait UsersTrait {

    public static function flushSession($user) {

        if (!is_array($user) || empty($user))
            return;


        $avatar = self::getAvatar($user);

        Session::put('user_id', $user['id']);

        $roles = json_encode($user['roles']);

        Session::put('user_data', [
            'auth' => $user['token'],
            'name' => $user['display_name'],
            'username' => $user['username'],
            'roles' => json_decode($roles, true),
            'bio' => $user['bio'],
            'avatar' => $avatar,
            'member_since' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user['created_at'])->format('M. Y'),
        ]);
    }

    public static function remember($user) {

        $token = \Hash::make(str_random(16));

        $response = \API::post('users/update/' . $user['id'], ['Authorization' => Session::get('user_data')['auth']], ['ID' => $user['id'], 'remember_token' => $token, '_method' => 'PUT']);

        return $response['code'] == 200 ? $token . '|' . $user['id'] : false;
    }

    public static function getClientId($user_id) {

        $data = \App\User::where('user_id', $user_id)->get();
        if (!empty($data->toArray()) && $data instanceof \Illuminate\Database\Eloquent\Collection) {
            return $data[0]->client_id;
        }
        return false;
    }

    public static function getAvatar($user) {

        $user = (array) $user;
        $avatar = url('/images/avatar-placeholder.png');

        if ($user['social'] == "0" && NULL != $user["avatar"]) {

            $avatar = getenv('API_BASE') . str_replace(".jpg", "-160.jpg", $user['avatar']);
        } elseif ($user["social"] == "1") {

            $avatar = $user['avatar'];
        }

        return $avatar;
    }

    public static function saveClient() {
        $user_id = Input::get('user_id');
        $client_id = Input::get('client_id');
        if (($user_id != NULL && !empty($user_id)) && ($client_id != NULL && !empty($client_id))) {
            $user = \DB::table('users')->where('user_id', $user_id)->get();
            if (empty($user)) {
                $user = \DB::table('users')->insert([
                    'user_id' => $user_id,
                    'client_id' => $client_id,
                    'last_seen' => \Carbon\Carbon::now()
                ]);
            } else {
                \DB::table('users')->where('user_id', $user_id)->update(['client_id' => $client_id ,'last_seen' => \Carbon\Carbon::now()]);
            }
        }

        return $user;
    }

}
