<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('employee_images', 'public');
        }


        if ($employee = Employee::find($request->get('employee_id'))) {
            if ($employee->image_path) {
                Storage::disk('public')->delete($employee->image_path);
            }
    
            $employee->image_path = $imagePath;
            $employee->update($request->all());
        } else {
            $employee = Employee::create($request->all());
            if ($employee->image_path) {
                Storage::disk('public')->delete($employee->image_path);
            }
    
            $employee->image_path = $imagePath;
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
