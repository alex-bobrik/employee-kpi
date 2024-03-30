<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeKpiResult extends Model
{
    use HasFactory;

    protected $table = 'employee_kpi_results';
    protected $primaryKey = 'result_id';

    protected $fillable = [
        'value',
        'date_measured'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function kpi()
    {
        return $this->belongsTo(Kpi::class, 'kpi_id', 'kpi_id');
    }
}
