<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Guard;
use Spatie\Permission\PermissionRegistrar;

class Role extends \Spatie\Permission\Models\Role
{
    /**
     * @return RoleContract|\Spatie\Permission\Models\Role
     *
     * @throws RoleAlreadyExists
     */
    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $params = ['name' => $attributes['name'], 'guard_name' => $attributes['guard_name']];
        if (app(PermissionRegistrar::class)->teams) {
            $teamsKey = app(PermissionRegistrar::class)->teamsKey;

            if (array_key_exists($teamsKey, $attributes)) {
                $params[$teamsKey] = $attributes[$teamsKey];
            } else {
                $attributes[$teamsKey] = getPermissionsTeamId();
            }
        }

        return static::query()->create($attributes);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
