<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter500 extends Model
{
    use HasFactory;
    protected $table = 'chapter500pricing';

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
