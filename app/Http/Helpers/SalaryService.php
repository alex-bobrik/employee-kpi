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
        $lastSalaryDate = $lastCalculatedSalary ? $lastCalculatedSalary->date_measured : Carbon::now()->subDays(30)->toDateString();
        $bonusBySalaryPeriod = self::getBonusBySalaryPeriod($employee_id, $lastSalaryDate);

        $total = ($baseValue * $workingHours) + (self::SICK_COEFF * $sickHours) + $bonusBySalaryPeriod;

        return $total;
    }

    public function getLastCalculatedSalary($employee_id)
    {
        $lastSalary = EmployeeSalaryResults::latest('date_measured')
            ->where('employee_id', $employee_id)
            ->first();

        return $lastSalary;
    }

    public function getBonusBySalaryPeriod($employee_id, $lastCalculatedSalaryDate)
    {
        $lastCalculated = Carbon::parse($lastCalculatedSalaryDate);

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