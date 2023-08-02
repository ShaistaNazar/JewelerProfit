<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter900 extends Model
{
    use HasFactory;

    protected $table = 'chapter900pricing';

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}

