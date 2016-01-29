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
        
        return self::$can ? true : false;
        
    }

    public function handle() {
        if (!self::$can)
            abort(401);
    }

}
