<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter800 extends Model
{
    use HasFactory;
    protected $table = 'chapter800pricing';
    
     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

        'stuller_sku' => 'array',
        'picklist_stuller_if_needed' => 'array',
        'dependent_part_stuller_if_needed' => 'array',
        'comparative_percentage_to_sku' => 'array',
        // 'JLRC_labor_torch' => 'array',
        // 'JLRC_labor_laser' => 'array'
    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
