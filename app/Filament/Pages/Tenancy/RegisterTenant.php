<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Role;
use App\Models\Tenant;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Spatie\Permission\Models\Permission;

class RegisterTenant extends \Filament\Pages\Tenancy\RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register tenant';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->unique(),
            ]);
    }

    protected function handleRegistration(array $data): Tenant
    {
        $user = auth()->user();
        $tenant = Tenant::create(array_merge($data, ['user_id' => $user->id]));

        $tenant->members()->attach(auth()->user());

        $this->createRoles($tenant, auth()->user());

        return $tenant;
    }

    /**
     * @return void
     */
    protected function createRoles(Tenant $tenant, $user)
    {
        session(['tenant_id' => $tenant->id]);
        setPermissionsTeamId($tenant->id);

        $role = Role::create([
            'name' => config('filament-shield.super_admin.name'),
            'tenant_id' => $tenant->id,
        ]);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $user->assignRole($role);
    }
}
