<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the shop for the jeweler.
     */
    
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'id', 'shop_id')->select(['id','shop_name', 'have_laser', 'ever_used_laser','owner_id','is_branch', 'is_main','trademark_url']);
    }

    /**
     * Get the itemsInOurCare of specific customer.
     */
    public function itemsInOurCare()
    {
        return $this->hasMany(ItemInOurCare::class,'customer_id','id')->select(['id','item_description', 'customer_stated_value', 'photo','stones_quality_description','is_guarranteed','customer_id']);
    }   

}
