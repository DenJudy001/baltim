<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salary_number',
        'name',
        'email',
        'telp',
        'salary',
    ];

    public function getRouteKeyName() {
        return 'salary_number';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
