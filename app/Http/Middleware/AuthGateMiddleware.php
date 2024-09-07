<?php

namespace App\Http\Middleware;

use App\Modules\UserPermission\Models\Permission;
use App\Modules\UserPermission\Models\Module;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            $modules = Module::all();
            foreach ($modules as $key => $module) {
                Gate::define($module->slug, function ($user) use ($module) {
                    if($user->role->slug == 'admin')
                    {
                        return true;
                    }
                    
                    return $user->hasModulePermission($module->slug);
                });
            }

            $permissions = Permission::all();
            foreach ($permissions as $key => $permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    if($user->role->slug == 'admin')
                    {
                        return true;
                    }
                    return $user->hasPermission($permission->slug);
                });
            }
        }
        return $next($request);
    }
}
