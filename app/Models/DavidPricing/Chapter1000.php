<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter1000 extends Model
{
    use HasFactory;
    protected $table = "chapter1000pricing";
    protected $casts = [

        'stuller_sku' => 'array',
        'chapter700'  => 'array'
    ];
    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
