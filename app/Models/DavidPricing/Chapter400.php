<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter400 extends Model
{
    use HasFactory;

    protected $table = 'chapter400pricing';

    protected $casts = [

        'stuller_sku' => 'array',
        'picklist_stuller_if_needed' => 'array',

    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
