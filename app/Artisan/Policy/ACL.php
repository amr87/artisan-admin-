<?php

namespace Artisan\Policy;

use Illuminate\Support\Facades\Session;

class ACL {

    protected static $can;

    public static function check($ability = NULL) {
        self::$can = false;
        if ($ability == NULL)
            return false;
        if (!Session::has('user_id') || !Session::has('user_data') || empty(Session::get('user_data')['roles']))
            return false;

        foreach (Session::get('user_data')['roles'] as $role) {
            if ($role->name == 'super_admin')
                self::$can = true;
            if (!empty($role->permissions) && $role->permissions !== NULL) {

                foreach ($role->permissions as $permission) {
                    if ($permission->name == $ability)
                        self::$can = true;
                }
            }
        }
        return new static;
    }

    public function decide() {

        return self::$can;
    }

    public function handle() {
        if (!self::$can)
            abort(401);
    }

    public static function flushSession($user) {

        if (!is_array($user) || empty($user))
            return;

        $avatar = url('/images/avatar-placeholder.png');

        if ($user['social'] == "0" && NULL != $user["avatar"]) {

            $avatar = getenv('API_BASE') . str_replace(".jpg", "-160.jpg", $user['avatar']);
        } elseif ($user["social"] == "1") {

            $avatar = $user['avatar'];
        }

        Session::put('user_data', [
            'auth' => $user['token'],
            'roles' => $user['roles'],
            'name' => $user['display_name'],
            'bio' => $user['bio'],
            'avatar' => $avatar,
            'member_since' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user['created_at'])->format('M. Y'),
        ]);
    }

    public static function getClientId($user_id) {

        $data = \DB::table('users')->where('user_id', '=', $user_id)->select('client_id')->get();
        if (!empty($data)) {
            return $data->client_id;
        }
        return false;
    }

}
