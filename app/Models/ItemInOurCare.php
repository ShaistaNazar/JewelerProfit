<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInOurCare extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'item_description',
        'customer_stated_value',
        'photos',
        'stones_quality_description',
        'is_guarranteed',
        'is_qualiteed',
        'envelope_id',
        'stones_guarrantee_description',
        'promise_date'
    ];
    
    protected $table = 'items_in_our_care';

    /**
     * Get the shop for the jeweler.
     */
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id', 'customer_id')->select(['id','firstname', 'lastname', 'customer_id','gender','home_phone', 'cell_phone','work_phone','alternative','primary_email','should_contact','secondary_email','street_address','apartment','city','zip','']);
    }
}
