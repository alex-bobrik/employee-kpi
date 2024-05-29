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

    public function averageKpi()
    {
        return $this->kpiResults()->avg('kpi_value') ?? 0;
    }

    public function getBonusByPeriod($from, $to)
    {
        return $this->kpiResults()->whereBetween('date_measured', [$from, $to])->sum('value');
    }

    public function getGroupedBonus()
    {
        return $this->kpiResults()
        ->selectRaw('date_measured, SUM(value) as total_bonus')
        ->groupBy('date_measured')
        ->get()
        ->toArray();   
    }

    public function getKpiResultsArray()
{
    return $this->kpiResults()
                ->join('kpis', 'employee_kpi_results.kpi_id', '=', 'kpis.kpi_id')
                ->selectRaw('kpis.name as kpi_name, avg(employee_kpi_results.kpi_value) as avg_kpi_value, employee_kpi_results.date_measured')
                ->groupBy('employee_kpi_results.date_measured', 'kpis.name')
                ->get()
                ->toArray();
}



}
