<?php

namespace App\Models;

use App\Models\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory, TenantTrait;

    protected $fillable = [
        'tenant_id',
        'email',
        'code',
        'roles',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'roles' => 'array',
    ];
}
