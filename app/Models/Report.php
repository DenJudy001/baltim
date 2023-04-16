<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_year',
        'report_periode',
        'kas',
        'piutang',
        'utang_usaha',
        'utang_bank',
    ];

    protected $with = ['dtl_reports'];

    public function dtl_reports(){
        return $this->hasMany(DetailReport::class ,'report_id');
    }

}
