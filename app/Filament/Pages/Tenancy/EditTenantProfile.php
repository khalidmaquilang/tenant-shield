<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class EditTenantProfile extends \Filament\Pages\Tenancy\EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Tenant profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('slug')
                    ->unique(ignoreRecord: true),
            ]);
    }
}
