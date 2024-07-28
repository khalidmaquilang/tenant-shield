<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('invite-user/register', \App\Filament\Pages\RegisterInvited::class)
    ->name('register.user-invite')
    ->middleware(['signed']);
