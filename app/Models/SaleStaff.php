<?php

namespace App\Models;

use App\Scopes\SaleStaffScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleStaff extends Model
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
        static::addGlobalScope(new SaleStaffScope);
    }

    protected $table = 'users';
    protected $guarded = [];

    /**
     * Get the shop for the sale person.
     */
    
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'id', 'shop_id');
    }
}
