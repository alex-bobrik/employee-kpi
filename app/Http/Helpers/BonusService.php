<?php

namespace App\Http\Helpers;

class BonusService {

    public function calculateBonus(float $kpiValue, float $baseValue, float $weight)
    {
        $bonus = ($kpiValue / 100) * $baseValue * ($weight / 100);

        return $bonus;
    }
}