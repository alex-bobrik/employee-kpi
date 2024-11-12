<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SalaryService;
use App\Models\Employee;
use App\Models\EmployeeSalaryResults;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private $salaryService;

    public function __construct(SalaryService $salaryService)
    {
        $this->salaryService = $salaryService;
    }

    public function index($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        $lastCalculatedSalary = Carbon::parse($this->salaryService->getLastCalculatedSalary($employeeId));
        $currentDate = Carbon::now();

        $daysSinceLastCalculation = $lastCalculatedSalary->diffInDays($currentDate);

        $bonusByPeriod = $this->salaryService->getBonusBySalaryPeriod($employeeId, $lastCalculatedSalary);

        return view('salary.index', [
            'employee' => $employee,
            'lastCalculatedSalary' => $lastCalculatedSalary->format('d M Y'),
            'bonusByPeriod' => $bonusByPeriod,
            'daysSinceLastCalculation' => $daysSinceLastCalculation,
        ]);
    }

    public function store(Request $request, $employeeId)
    {
        $requestData = $request->all();
        $employee = Employee::findOrFail($employeeId);

        $baseValue = $employee->base_value;
        $workingHours = (float) $requestData['workingHours'];
        $sickHours = (float) $requestData['sickDays'] * 8;

        $lastCalculatedSalary = $this->salaryService->getLastCalculatedSalary($employeeId);
        $bonusByPeriod = $this->salaryService->getBonusBySalaryPeriod($employeeId, $lastCalculatedSalary);

        $totalSalary = $baseValue * $workingHours + $this->salaryService::SICK_COEFF * $sickHours + $bonusByPeriod;

        $salaryData = [
            'employee_id' => $employeeId,
            'working_hours' => $workingHours,
            'sick_hours' => $sickHours,
            'bonus' => $bonusByPeriod,
            'total' => $totalSalary,
            'date_measured' => Carbon::now(),
        ];

        EmployeeSalaryResults::create($salaryData);


        return redirect()->route("employeeProfile", ['id' => $employeeId])->with("message", [
            'text' => 'Salary added',
            'status' => 'success'
        ]);
    }
}
