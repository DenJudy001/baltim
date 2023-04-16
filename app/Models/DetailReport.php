<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'name',
        'type',
        'month_asset',
        'year_asset',
        'price',
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
