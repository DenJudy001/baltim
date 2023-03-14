<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'stuff_name',
        'description',
        'price',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
