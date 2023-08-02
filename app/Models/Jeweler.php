<?php

namespace App\Models;

use App\Scopes\JewelerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jeweler extends Model
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
        static::addGlobalScope(new JewelerScope);
    }

    protected $table = 'users';
    protected $guarded = [];

    /**
     * Get the shop for the jeweler.
     */
    
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    /**
     * jobs under jeweler
     */

    public function jewelJobs()
    {
        return $this->hasMany(JobHistory::class, 'jeweler_id', 'id')->where('status',config('job_statuses.delivered'))
                                                                    ->whereNotNull('envelope_id')
                                                                    ->whereNotNull('delivered_at');
    }
    
    /**
     * Get the jeweler's labour.
     */
    public function jewelerLabor()
    {
        return $this->hasManyThrough(GellerPrice::class, JobHistory::class,'jeweler_id','sku','id','sku');
    }

}
