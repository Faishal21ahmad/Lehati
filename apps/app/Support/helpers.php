<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('canAccess')) {
    function canAccess(string $permission): bool
    {
        $user = Auth::user();
        return $user && $user->role->hasPermission($permission);
    }
}
