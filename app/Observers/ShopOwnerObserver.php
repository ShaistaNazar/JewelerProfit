<?php

namespace App\Observers;

use App\Models\ShopOwner;
use Spatie\Permission\Models\Role;

class ShopOwnerObserver
{
    /**
     * Handle the ShopOwner "created" event.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return void
     */
    public function created(ShopOwner $shopOwner)
    {
        $shopOwner->role_id = Role::where('name','shop_owner')->first()->id;
        $shopOwner->save();
    }

    /**
     * Handle the ShopOwner "updated" event.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return void
     */
    public function updated(ShopOwner $shopOwner)
    {
        //
    }

    /**
     * Handle the ShopOwner "deleted" event.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return void
     */
    public function deleted(ShopOwner $shopOwner)
    {
        //
    }

    /**
     * Handle the ShopOwner "restored" event.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return void
     */
    public function restored(ShopOwner $shopOwner)
    {
        //
    }

    /**
     * Handle the ShopOwner "force deleted" event.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return void
     */
    public function forceDeleted(ShopOwner $shopOwner)
    {
        //
    }
}
