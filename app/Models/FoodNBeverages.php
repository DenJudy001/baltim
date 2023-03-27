<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodNBeverages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'image',
        'price',
    ];


    
}
