<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;

    protected $fillable =[
        'pos_number',
        'responsible',
        'state',
        'total',
        'end_date',
        'end_by',
    ];

    protected $with = ['dtl_pos'];

    public function getRouteKeyName() {
        return 'pos_number';
    }

    public function dtl_pos(){
        return $this->hasMany(DetailPos::class ,'pos_id');
    }
}
