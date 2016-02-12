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

trait UsersTrait {

    public static function flushSession($user) {

        if (!is_array($user) || empty($user))
            return;

        $avatar = url('/images/avatar-placeholder.png');

        if ($user['social'] == "0" && NULL != $user["avatar"]) {

            $avatar = getenv('API_BASE') . str_replace(".jpg", "-160.jpg", $user['avatar']);
        } elseif ($user["social"] == "1") {

            $avatar = $user['avatar'];
        }
     
        Session::put('user_id',$user['id']);
        
        Session::put('user_data', [
            'auth' => $user['token'],
            'roles' => $user['roles'],
            'name' => $user['display_name'],
            'bio' => $user['bio'],
            'avatar' => $avatar,
            'member_since' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user['created_at'])->format('M. Y'),
        ]);
        
       
    }

    public static function remember($user) {
        $token = \Hash::make(str_random(16));
        $response = \API::post('users/update/' . $user['id'], ['Authorization' => Session::get('user_data')['auth']], ['ID' => $user['id'], 'remember_token' => $token, '_method' => 'PUT']);
        return $response['code'] == 200 ? base64_decode($token . '|' . $user['id']) : false;
    }

    public static function getClientId($user_id) {

        $data = \DB::table('users')->where('user_id', '=', $user_id)->select('client_id')->get();
        if (!empty($data)) {
            return $data->client_id;
        }
        return false;
    }

}
