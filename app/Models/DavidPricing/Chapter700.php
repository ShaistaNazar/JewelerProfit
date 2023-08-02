<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter700 extends Model
{
    use HasFactory;

    protected $table = 'chapter700pricing';
    
    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
