<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class SuperAdminScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */

    public function apply(Builder $builder, Model $model)
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();

        if ($superAdminRole) {
            $builder->where('role_id', $superAdminRole->id);
        }
        
    }

}