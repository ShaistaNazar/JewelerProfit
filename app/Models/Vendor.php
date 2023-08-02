<?php

namespace App\Models;

use App\Scopes\VendorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();
        static::addGlobalScope(new VendorScope);
    }
    protected $guarded = [];
    protected $table = 'users';

    /**
     * Get the shop for the sale person.
     */
    
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'id', 'shop_id');
    }
}
