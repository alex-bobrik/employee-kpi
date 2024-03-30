<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'firstname',
        'lastname',
        'department',
        'base_value'
    ];

    public function kpiResults()
    {
        return $this->hasMany(EmployeeKpiResult::class, 'employee_id', 'employee_id');
    }
}
