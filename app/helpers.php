<?php

use App\Models\User;

if (!function_exists('roles_list')) {
    function roles_list(): array
    {
        $roles = [];
        foreach (config('system.roles') as $key => $value) {
            $roles[$key] = __($value['title']);
        }
        return $roles;
    }
}

if (!function_exists('has_all_permissions')) {
    function has_all_permissions(User $user, ...$permissions): bool
    {
        if ($user->role) {
            $role = config('system.roles.' . $user->role);
            if ($role) {
                return sizeof(array_intersect($role['permissions']['functions'], $permissions)) === sizeof($permissions);
            }
            return false;
        }
        return false;
    }
}

if (!function_exists('has_any_permissions')) {
    function has_any_permissions(User $user, ...$permissions): bool
    {
        if ($user->role) {
            $role = config('system.roles.' . $user->role);
            if ($role) {
                return sizeof(array_intersect($role['permissions']['functions'], $permissions));
            }
            return false;
        }
        return false;
    }
}

if (!function_exists('can_access_page')) {
    function can_access_page(User $user, ...$pages): bool
    {
        if ($user->role) {
            $role = config('system.roles.' . $user->role);
            if ($role) {
                return sizeof(array_intersect($role['permissions']['pages'], $pages));
            }
            return false;
        }
        return false;
    }
}
