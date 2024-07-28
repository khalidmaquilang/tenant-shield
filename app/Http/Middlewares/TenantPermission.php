<?php

namespace App\Http\Middlewares;

class TenantPermission
{
    /**
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! empty(auth()->user())) {
            session(['tenant_id' => filament()->getTenant()->id]);
            setPermissionsTeamId(filament()->getTenant()->id);
        }

        return $next($request);
    }
}
