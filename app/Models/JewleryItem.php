<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JewleryItem extends Model
{
    use HasFactory;

    /**
     * Get the comments for the blog post.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
