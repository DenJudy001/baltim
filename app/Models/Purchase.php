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
        'supplier_name',
        'description',
        'address',
        'supplier_responsible',
        'telp',
        'purchase_number',
        'purchase_name',
        'responsible',
        'state',
        'total',
        'end_date',
    ];

    protected $with = ['dtl_purchase','series'];

    public function getRouteKeyName() {
        return 'purchase_number';
    }

    public function dtl_purchase(){
        return $this->hasMany(DetailPurchase::class ,'purchase_id');
    }

    public function series(){
        return $this->belongsTo(Series::class);
    }
}
