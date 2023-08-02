<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter1100 extends Model
{
    use HasFactory;
    protected $table = "chapter1100pricing";

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
