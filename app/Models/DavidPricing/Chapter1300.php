<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter1300 extends Model
{
    use HasFactory;

    protected $table = "chapter1300pricing";

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'stuller_sku' => 'array',
    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
