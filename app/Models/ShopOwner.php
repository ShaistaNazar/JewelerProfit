<?php

namespace App\Models;
use App\Scopes\ShopOwnerScope;

use Spatie\Permission\Models\Permission;

class ShopOwner extends User
{
    

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();
        static::addGlobalScope(new ShopOwnerScope);
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
