<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    use HasFactory;
    protected $table = 'job_histories';

    protected $fillable = [

        'is_rush',
        'rush_service',
        'price_chart',
        'status',
        'placed_at',
        'desired_at',
        'completed_at',
        'delivered_at',
        'jeweler_id',
        'envelope_id',
        "geller_sku",
        "labor_formula",
        "part_cost",
        "part_retail",
        "labor_cost",
        "labor_retail",
        "total_with_labor_and_part",
        'rhodium_charges',
        "picklist_charges",
        "service_id",
        "other_retail",
        "other_cost",
        "other_note",
        'grand_total',
        "total_cost",
        "total_retail",
        "sales_tax",
        'total_with_sales_tax',
        'is_discount_applied',
        'JLRC',
        'setting_charges',
        'soldering_charges',
        'sale_person_performed_job',
        'sale_person_id',
        'is_estimated',
        'customer_number',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    
    protected $casts = [

        'pick_list' => 'array',
        'setting_charges' => 'array',
        'soldering_charges' => 'array',
        'picklist_charges' => 'array',
        'price_chart' => 'array'
    ];
    
    /**
     * price related to job 
     */
    public function JLRC()
    {
        return $this->hasOne(GellerPrice::class,'sku','sku');
    }

    /**
     * price related to job 
     */
    public function jeweler()
    {
        return $this->hasOne(Jeweler::class,'id','jeweler_id');
    }

}
