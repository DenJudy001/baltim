<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'series_id',
        'supplier_id',
        'purchase_number',
        'purchase_name',
        'responsible',
        'state',
        'total',
        'end_date',
    ];

    protected $with = ['dtl_purchase','series'];

    public function dtl_purchase(){
        return $this->hasMany(DetailPurchase::class);
    }

    public function series(){
        return $this->belongsTo(Series::class);
    }
}
