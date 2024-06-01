<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index() 
    {
        return view("employee.list", [
            "employeeList" => Employee::all()
        ]);
    }

    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        $employee->save();

        return redirect()->route("employeeList")->with("message", [
            'text' => 'Employee created',
            'status' => 'success'
        ]);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return view("employee.profile", [
            "employee" => $employee
        ]);
    }

    public function update(Request $request)
    {
        if (        $employee = Employee::find($request->get('employee_id'))) {
            $employee->update($request->all());

        } else {
            $employee = Employee::create($request->all());
        $employee->save();
        }

        return redirect()->route("employeeList")->with("message", [
            'text' => 'Employee updated',
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        $employee = Employee::find($request->get('employee_delete_id'));
        $employee->delete();

        return redirect()->route('employeeList')->with('message', [
            'text' => 'Employee deleted',
            'status' => 'success'
        ]);
    }
}
