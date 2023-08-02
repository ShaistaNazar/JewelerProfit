<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'trademark_url',
        'owner_id',
        'have_laser',
        'street_address',
        'zip_code',
        'city',
        'apartment',
        'contact_no',
    ];

    /**
     * Get the shopOwner for the shop.
     */
    
    public function shopOwner()
    {
        return $this->belongsTo(ShopOwner::class, 'owner_id', 'id')->select(['id','fullname', 'email','contact_no','address']);
    }

    /**
     * Get the jewelers for the shop.
     */
    public function jewelers()
    {
        return $this->hasMany(Jeweler::class,'shop_id','id')->select(['id','fullname', 'email','contact_no','address','shop_id']);
    }

    /**
     * Get the saleStaff for the shop.
     */
    public function saleStaff()
    {
        return $this->hasMany(SaleStaff::class,'shop_id','id')->select(['id','fullname', 'email','contact_no','address']);
    }

    /**
     * Get the saleStaff for the shop.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class,'shop_id','id')->select(['id','firstname', 'lastname', 'customer_id','email','cell_phone','shop_id','gender',
        'street_address','apartment','city','zip','birth_date','should_contact','alternative','spouce_f_name','spouce_l_name']);
    }

     /**
     * Get the saleStaff for the shop.
     */
    public function vendors()
    {
        return $this->hasMany(Vendor::class,'shop_id','id')->select(['id','fullname', 'email','contact_no','address']);
    }

    /**
     * Get the global vendors for the shop.
     */
    public function global_vendors()
    {
        return $this->hasMany(GlobalVendor::class,'shop_id','id')->select(['id','name', 'link','shop_id']);
    }
    
     /**
     * Get the saleStaff for the shop.
     */
    public function estimated_items()
    {									
        return $this->hasMany(EstimatedItem::class,'shop_id','id')->select(['id','service_id', 'envelope_id','geller_sku',
                                                                            'vendor_id','shop_id','shop_id','estimated_cost_finalized',
                                                                            'customer_number','date_sent','date_received_back_into_store',
                                                                            'estimated_cost_from','estimated_cost_to','retail_price',
                                                                            'is_rush','work_to_be_performed','customer_approved_or_declined']);
    }

     /**
     * Get the shank details for the shop.
     */
    public function shop_shank_details()
    {
        return $this->hasOne(ShopShankDetails::class,'shop_id','id')->select(['id','latest_pricing_date', 'vendor_phone_number',
                                                                               'vendor_cost_markup','is_default']);
    }
    
    public function chapter100()
    {									 
        return $this->hasMany(DavidPricing\Chapter100::class,'shop_id','id')->select(['id','geller_sku','major_item',
         'type','karats','size','color','first_size_larger','each_additional_size_JLRC',
         'JLRC','width','silver_stone_specification','description','shape']);
    }

    public function chapter200()
    {									 

        return $this->hasMany(DavidPricing\Chapter200::class,'shop_id','id')->
        select(['id','geller_sku','major_item','type','karats','JLRC_labor_torch','JLRC_labor_laser']);

    }

    public function chapter300()
    {									 

        return $this->hasMany(DavidPricing\Chapter300::class,'shop_id','id')->
        select(['id','geller_sku','major_item','size','karats','JLRC_labor_torch','JLRC_labor_laser']);

    }

    public function chapter700()
    {									 

        return $this->hasMany(DavidPricing\Chapter700::class,'shop_id','id')->
        select(['id','geller_sku','setting_type','major_item','item_type',
        'carats','stone_size','setting_labor_without_discount','setting_labor_with_discount',
        'JLRC_without_discount','JLRC_with_discount','no_of_price_criteria_item']);

    }

    public function chapter900()
    {									 

        return $this->hasMany(DavidPricing\Chapter900::class,'shop_id','id')
        ->select(['id','geller_sku','major_item','complexity','description',
        'welding_technology','soldering_labor_without_discount','soldering_labor_with_discount',
        'JLRC_without_discount','JLRC_with_discount']);

    }

    public function chapter1000()
    {
        return $this->hasMany(DavidPricing\Chapter1000::class,'shop_id','id')
        ->select(['id','geller_sku','major_item','retail_labor','type','cast_into','karats','description','way_around','length_of_chain','stone_details','who_keeps_mold']);
    }

    public function sort_box_jobs()
    {
        # code...
        return $this->hasMany(JobHistory::class,'shop_id','id')->where('location','sort_box')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    // public function order_box_jobs()
    // {
    //     # code...
    //     return $this->hasMany(JobHistory::class,'shop_id','id')->where('location','sort_box')
    //     ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
    //     'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    // }

}




