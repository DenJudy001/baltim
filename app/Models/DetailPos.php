<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPos extends Model
{
    use HasFactory;

    protected $fillable =[
        'pos_id',
        'fnb_id',
        'name',
        'description',
        'type',
        'image',
        'qty',
        'price',
    ];

    public function purchase(){
        return $this->belongsTo(Pos::class);
    }
}
