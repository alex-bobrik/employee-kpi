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

        $lastCalculatedSalary = $this->salaryService->getLastCalculatedSalary($employeeId);
        $lastCalculatedDate = $lastCalculatedSalary ? Carbon::parse($lastCalculatedSalary->date_measured) : Carbon::now()->subDays(30);
        $currentDate = Carbon::now();

        $daysSinceLastCalculation = $lastCalculatedDate->diffInDays($currentDate);

        $bonusByPeriod = $this->salaryService->getBonusBySalaryPeriod($employeeId, $lastCalculatedDate);

        return view('salary.index', [
            'employee' => $employee,
            'lastCalculatedSalary' => $lastCalculatedDate->format('d M Y'),
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
        $lastSalaryDate = $lastCalculatedSalary ? $lastCalculatedSalary->date_measured : Carbon::now()->subDays(30);
        $bonusByPeriod = $this->salaryService->getBonusBySalaryPeriod($employeeId, $lastSalaryDate);

        $totalSalary = $baseValue * $workingHours + $this->salaryService::SICK_COEFF * $sickHours + $bonusByPeriod;

        $salaryData = [
            'employee_id' => $employeeId,
            'working_hours' => $workingHours,
            'sick_hours' => $sickHours,
            'bonus' => $bonusByPeriod,
            'total' => $totalSalary,
            'date_measured' => Carbon::now(),
            'from_measured' => Carbon::parse($lastSalaryDate)->format('Y-m-d'),
        ];

        $salaryModel = EmployeeSalaryResults::create($salaryData);

        return redirect()->route("salary.payslip", 
        ['salaryId' => $salaryModel->id])->with("message", [
            'text' => 'Payslip created',
            'status' => 'success'
        ]);
    }

    public function payslip($salaryId)
    {
        $salaryModel = EmployeeSalaryResults::findOrFail($salaryId);
        $employee = Employee::findOrFail($salaryModel->employee_id);

        return view('salary.payslip', [
            'employee' => $employee,
            'salaryModel' => $salaryModel,
        ]);
    }

    public function delete(Request $request)
    {
        if($salaryResult = EmployeeSalaryResults::find($request->get('salary_delete_id'))) {
            $salaryResult->delete();
        }

        return redirect()->route("employeeProfile", ['id' => $request->get('salary_employee_id')])->with("message", [
            'text' => 'Salary result deleted',
            'status' => 'success'
        ]);
    }
}
