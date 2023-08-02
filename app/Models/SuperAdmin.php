<?php

namespace App\Models;

use App\Scopes\SuperAdminScope;

class SuperAdmin extends User
{

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new SuperAdminScope);
    }
    
    protected $table = 'users';

    /**
     * Get the shop that shop owner belongs to.
     */
    public function shop()
    {
        return $this->hasOne(Shop::class,'owner_id','id');
    }
}
