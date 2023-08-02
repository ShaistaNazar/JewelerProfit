<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimatedItem extends Model
{
    use HasFactory;
    protected $fillable = [

        'service_id',
        'envelope_id',
        'vendor_id',
        'shop_id',
        'date_sent',
        'date_received_back_into_store',
        'estimated_cost_from',
        'estimated_cost_to',
        'estimated_cost_finalized',
        'retail_price',
        'work_to_be_performed',
        'customer_approved_or_declined',
        'customer_number',
        'is_rush',
        'geller_sku'

    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->select(['id','fullname','email']);
    }
}
