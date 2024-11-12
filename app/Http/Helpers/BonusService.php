<?php

namespace App\Http\Helpers;

use App\Models\EmployeeKpiResult;
use Carbon\Carbon;

class BonusService {

    public function calculateBonus(float $kpiValue, float $baseValue, float $weight)
    {
        $bonus = ($kpiValue / 100) * $baseValue * ($weight / 100);

        return $bonus;
    }

    public function getLastCalculatedBonus($employee_id)
    {
        $lastBonus = EmployeeKpiResult::latest('date_measured')
            ->where('employee_id', $employee_id)
            ->first();

        if ($lastBonus) {
            return $lastBonus->date_measured;
        }

        return Carbon::now()->subDays(30);
    }
}