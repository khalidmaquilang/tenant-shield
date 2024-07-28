<?php

namespace App\Models\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Always add this trait to your new model if you want to scope this in your tenant
 * make sure your model has tenant_id field.
 */
trait TenantTrait
{
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('only_tenant', function (Builder $builder) {
            if (empty(filament()->getTenant())) {
                return;
            }

            $builder->where('tenant_id', filament()->getTenant()->id);
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
