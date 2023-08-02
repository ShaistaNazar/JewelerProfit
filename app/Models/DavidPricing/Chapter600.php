<?php

namespace App\Models\DavidPricing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter600 extends Model
{
    use HasFactory;

    protected $table = "chapter600pricing";

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
