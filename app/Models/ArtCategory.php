<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'art_id',
        'category_id',
    ];
}
