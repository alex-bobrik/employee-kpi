<?php

namespace App\Http\Controllers;

use App\Http\Helpers\BonusService;
use App\Models\Employee;
use App\Models\EmployeeKpiResult;
use App\Models\Kpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class EmployeeKpiResultController extends Controller
{

    private $bonusService;

    public function __construct(BonusService $bonusService)
    {
        $this->bonusService = $bonusService;
    }

    public function index($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        return view('kpiResults.index', [
            'employee' => $employee,
            'kpis' => Kpi::all(),
        ]);
    }

    public function store(Request $request, $employeeId)
    {
        $requestKpis = $request->all();
        $employee = Employee::findOrFail($employeeId);

        foreach ($requestKpis as $kpiId => $kpiValue) {
            if (!$kpi = Kpi::find($kpiId)) {
                continue;
            }

            $data = [
                'employee_id' => $employeeId,
                'user_id' => Auth::user()->user_id,
                'kpi_id' => $kpiId,
                'kpi_value' => (float)$kpiValue,
                'value' => $this->bonusService->calculateBonus((float)$kpiValue, (float)$employee->base_value, (float)$kpi->weight_value),
                // 'value' => (float)$employee->base_value * (float)$kpiValue * ((float)$kpi->weight_value / 100),
                'date_measured' => Date::now()
            ];

            EmployeeKpiResult::create($data)->save();
        }

        return redirect()->route("employeeProfile", ['id' => $employeeId])->with("message", [
            'text' => 'KPI result added',
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        if($kpiResult = EmployeeKpiResult::find($request->get('result_delete_id'))) {
            $kpiResult->delete();
        }

        return redirect()->route("employeeProfile", ['id' => $request->get('result_employee_id')])->with("message", [
            'text' => 'KPI result deleted',
            'status' => 'success'
        ]);
    }
}
