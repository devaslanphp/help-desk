<?php

if (!function_exists('roles_list')) {
    function roles_list () {
        $roles = [];
        foreach (config('system.roles') as $key => $value) {
            $roles[$key] = __($value['title']);
        }
        return $roles;
    }
}
