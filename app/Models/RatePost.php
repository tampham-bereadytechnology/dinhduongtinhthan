<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatePost extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'post_category',
        'rating_stars',
    ];
}
