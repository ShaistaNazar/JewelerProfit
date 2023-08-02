<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

class Chapter100 extends Model
{
    use HasFactory;
    protected $table = "chapter100pricing";

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $guarded = [];
    protected $casts = [
         
        'stuller_sku_for_metal_pricing_for_each_size_larger' => 'array',
        'master_price_columns' => 'array'
    ];

    // public static function trimArrayValues($val)
    // {
    //     if(is_string($val))
    //         return trim($val);
    //     else
    //         return $val;
    // }


    public static function trimOptions(array $values)
    {
        $trimmed_values = array_map(function ($values) {
            
            if (is_string($values)) {
                $values = trim($values);
                return $values;
            }
        
        }, $values);
        return $trimmed_values;    
    }  

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
