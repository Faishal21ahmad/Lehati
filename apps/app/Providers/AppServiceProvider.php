<?php

namespace App\Providers;

use App\Enums\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Carbon::setLocale('id');
        foreach (Role::cases() as $role) {
            foreach ($role->permissions() as $permission) {
                Gate::define($permission, function ($user) use ($permission) {
                    return $user->role->hasPermission($permission);
                });
            }
        }
    }
}
