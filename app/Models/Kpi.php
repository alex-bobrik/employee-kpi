<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;

    protected $table = 'kpis';
    protected $primaryKey = 'kpi_id';

    protected $fillable = [
        'name',
        'description',
        'weight_value'
    ];

    public function kpiResults()
    {
        return $this->hasMany(EmployeeKpiResult::class, 'kpi_id', 'kpi_id');
    }
}
