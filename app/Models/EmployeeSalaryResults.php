<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryResults extends Model
{
    use HasFactory;

    protected $table = 'employee_salary_results';

    protected $fillable = [
        'employee_id',
        'working_hours',
        'sick_hours',
        'bonus',
        'total',
        'date_measured',
        'from_measured',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
