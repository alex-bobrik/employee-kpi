<?php

namespace App\Http\Helpers;

use App\Models\EmployeeKpiResult;
use App\Models\EmployeeSalaryResults;
use Carbon\Carbon;

class SalaryService {

    public const SICK_COEFF = 0.75;

    public function calculateSalary($employee_id, float $baseValue, int $workingHours, int $sickHours)
    {
        $lastCalculatedSalary = self::getLastCalculatedSalary($employee_id);
        $bonusBySalaryPeriod = self::getBonusBySalaryPeriod($employee_id, $lastCalculatedSalary);

        $total = ($baseValue * $workingHours) + (self::SICK_COEFF * $sickHours) + $bonusBySalaryPeriod;

        return $total;
    }

    public function getLastCalculatedSalary($employee_id)
    {
        $lastSalary = EmployeeSalaryResults::latest('date_measured')
            ->where('employee_id', $employee_id)
            ->first();

        if ($lastSalary) {
            return $lastSalary->date_measured;
        }

        return Carbon::now()->subDays(30)->toDateString();
    }

    public function getBonusBySalaryPeriod($employee_id, $lastCalculatedSalary)
    {
        $lastCalculated = Carbon::parse($lastCalculatedSalary);

        $kpiResults = EmployeeKpiResult::where('employee_id', $employee_id)
            ->whereBetween('date_measured', [$lastCalculated, Carbon::now()])
            ->get();

        if ($kpiResults->isNotEmpty()) {
            $totalBonus = $kpiResults->sum('value');
            // $daysBetween = $lastCalculated->diffInDays(Carbon::now());

            return $totalBonus;
        }

        return 0;
    }
}