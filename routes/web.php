<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [\App\Http\Controllers\SessionController::class, 'loginForm'])->name('loginForm');
Route::post('loginPost', [\App\Http\Controllers\SessionController::class, 'loginPost'])->name('loginPost');
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect()->route('loginForm');
})->name('logout');

Route::group(['middleware' => 'auth'], function () {

    Route::get('employee', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employeeList');
    Route::get('employee/{id}', [\App\Http\Controllers\EmployeeController::class, 'show'])->name('employeeProfile');
    
    Route::get('manager', [\App\Http\Controllers\SessionController::class, 'list'])->name('managerList');
    Route::post('/update-manager', [\App\Http\Controllers\SessionController::class, 'update'])->name('update-manager');
    Route::post('/delete-manager', [\App\Http\Controllers\SessionController::class, 'delete'])->name('delete-manager');
    
    
    
    
    Route::post('/update-employee', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('update-employee');
    Route::post('/delete-employee', [\App\Http\Controllers\EmployeeController::class, 'delete'])->name('delete-employee');
    
    
    Route::get('kpi', [\App\Http\Controllers\KpiController::class, 'index'])->name('kpiList');
    
    Route::post('/update-kpi', [\App\Http\Controllers\KpiController::class, 'update'])->name('update-kpi');
    Route::post('/delete-kpi', [\App\Http\Controllers\KpiController::class, 'delete'])->name('delete-kpi');
    
    Route::get('kpi-results-new/{employeeId}', [\App\Http\Controllers\EmployeeKpiResultController::class, 'index'])->name('newKpiResult');
    Route::post('kpi-results-save/{employeeId}', [\App\Http\Controllers\EmployeeKpiResultController::class, 'store'])->name('kpiResult.store');
    Route::post('/delete-result', action: [\App\Http\Controllers\EmployeeKpiResultController::class, 'delete'])->name('delete-result');

    Route::get('salary-new/{employeeId}', [\App\Http\Controllers\SalaryController::class, 'index'])->name('newSalary');
    Route::post('salary-save/{employeeId}', [\App\Http\Controllers\SalaryController::class, 'store'])->name('salary.store');
    Route::get('salary-payslip/{salaryId}', [\App\Http\Controllers\SalaryController::class, 'payslip'])->name('salary.payslip');
    Route::post('/delete-salary-result', action: [\App\Http\Controllers\SalaryController::class, 'delete'])->name('salary.delete');



});





