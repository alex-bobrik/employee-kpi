<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function showList()
    {
        return view('employee.list');
    }
}
