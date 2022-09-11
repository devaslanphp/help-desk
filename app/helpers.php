<?php

use App\Models\User;

if (!function_exists('roles_list')) {
    /**
     * Return roles list as an array of KEY (role id) => VALUE (role title)
     *
     * @return array
     */
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
    /**
     * Check if the user has all the permissions passed as parameters
     *
     * @param User $user
     * @param ...$permissions
     * @return bool
     */
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
    /**
     * Check if the user has any of the permissions passed as parameters
     *
     * @param User $user
     * @param ...$permissions
     * @return bool
     */
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
    /**
     * Check if the user can access the pages passed as parameters
     *
     * @param User $user
     * @param ...$pages
     * @return bool
     */
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
