<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favoriteSKU extends Model
{
    use HasFactory;
    protected $table = 'favoriteskus';
    protected $guarded = [];
}
