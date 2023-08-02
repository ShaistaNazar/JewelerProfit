<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvelopeDetail extends Model
{
    use HasFactory;
    protected $table = 'envelope_details';
    protected $guarded = [];

    public function order_box_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')->where('location','order_box')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    public function hold_box_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')->where('location','hold_box')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    public function finished_box_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')->where('location','finished_box')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    public function polish_room_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')->where('location','polish')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    public function cad_waxer_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')->where('location','cad_waxer')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    public function appraiser_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')->where('location','appraiser')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }

    public function jeweler()
    {
        return $this->hasOne(User::class,'id','jeweler_id');
    }
    public function sale_person()
    {
        return $this->hasOne(User::class,'id','sale_person_id');
    }

    public function vendor()
    {
        return $this->hasOne(GlobalVendor::class,'id','vendor_id');
    }

    public function sort_box_job_history()
    {
        # code...
        return $this->hasOne(JobHistory::class,'envelope_id','envelope_id')
        ->select(['id','grand_total','sales_tax','service_id','is_rush','price_chart','customer_number',
        'items_in_our_care_id','jeweler_id','sale_person_id','envelope_id','created_at']);
    }
}
