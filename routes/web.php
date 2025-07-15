<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\ShiftController;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('login.index');
});

Route::get('/in', function () {
    return view('record.in');
});

Route::get('/out', function () {
    return view('record.out');
});

Route::post('/recordin', [RecordController::class, 'storein'])->name('recordin');
Route::post('/recordout', [RecordController::class, 'storeout'])->name('recordout');

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('pages')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth', 'MustAdmin')->name('dashboard');

    Route::get('user', [UserController::class, 'index'])->middleware(['auth', 'MustAdmin'])->name('user');
    Route::post('useradd', [UserController::class, 'store'])->middleware(['auth', 'MustAdmin'])->name('add-user');
    Route::post('userdetail', [UserController::class, 'show'])->middleware(['auth', 'MustAdmin'])->name('detail-user');
    Route::patch('userupdate/{id}', [UserController::class, 'update'])->middleware(['auth', 'MustAdmin'])->name('update-user');
    Route::patch('userinactive/{id}', [UserController::class, 'inactive'])->middleware(['auth', 'MustAdmin'])->name('inactive-user');
    Route::patch('update-password/{id}', [UserController::class, 'updatePassword'])->middleware(['auth', 'MustAdmin'])->name('update.password');

    Route::get('employee', [EmployeeController::class, 'index'])->middleware(['auth', 'MustAdmin'])->name('employee');
    Route::post('employeeadd', [EmployeeController::class, 'store'])->middleware(['auth', 'MustAdmin'])->name('add-employee');
    Route::post('employeedetail', [EmployeeController::class, 'show'])->middleware(['auth', 'MustAdmin'])->name('detail-employee');
    Route::patch('employee/{id}', [EmployeeController::class, 'update'])->middleware(['auth', 'MustAdmin'])->name('update-employee');
    Route::patch('employeeinactive/{id}', [EmployeeController::class, 'inactive'])->middleware(['auth', 'MustAdmin'])->name('inactive-employee');
    Route::get('filteremployee', [EmployeeController::class, 'index'])->name('employee-filter');

    Route::get('shift', [ShiftController::class, 'index'])->middleware(['auth', 'MustDepthead'])->name('shift');
    Route::post('shiftadd', [ShiftController::class, 'store'])->middleware(['auth', 'MustDepthead'])->name('upload-shift');

    Route::get('emergency', [EmergencyController::class, 'index'])->middleware(['auth', 'MustLeader'])->name('emergency');
    Route::post('save-emergency', [EmergencyController::class, 'store'])->middleware(['auth', 'MustLeader'])->name('save-emergency');
    Route::post('save-evacuation', [EmergencyController::class, 'storeEvacuation'])->middleware(['auth', 'MustLeader'])->name('save-evacuation');
    Route::get('filteremergency', [EmergencyController::class, 'index'])->middleware(['auth', 'MustLeader'])->name('emergency-filter');

    Route::get('report', [ReportController::class, 'index'])->middleware('auth', 'MustDepthead')->name('report');
    Route::post('report', [ReportController::class, 'filter'])->middleware('auth', 'MustDepthead')->name('reportfilter');
});
