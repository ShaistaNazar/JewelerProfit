<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter200 extends Model
{
    use HasFactory;
    protected $table = 'chapter200pricing';

    protected $casts = [

        'stuller_sku' => 'array',
        'dependent_part_stuller_if_needed' => 'array',
        // 'JLRC_labor_torch' => 'array',
        // 'JLRC_labor_laser' => 'array'
    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
