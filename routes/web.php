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
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::prefix('pages')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth');

    Route::get('user', [UserController::class, 'index'])->middleware(['auth', 'mustAdmin'])->name('user');
    Route::post('useradd', [UserController::class, 'store'])->middleware(['auth', 'mustAdmin'])->name('add-user');
    Route::post('userdetail', [UserController::class, 'show'])->middleware(['auth', 'mustAdmin'])->name('detail-user');
    Route::patch('user/{id}', [UserController::class, 'update'])->middleware(['auth', 'mustAdmin'])->name('update-user');
    Route::patch('userinactive/{id}', [UserController::class, 'inactive'])->middleware(['auth', 'mustAdmin'])->name('inactive-user');
    Route::patch('update-password/{id}', [UserController::class, 'updatePassword'])->middleware(['auth', 'mustAdmin'])->name('update.password');

    Route::get('employee', [EmployeeController::class, 'index'])->middleware(['auth', 'mustAdmin'])->name('employee');
    Route::post('employeeadd', [EmployeeController::class, 'store'])->middleware(['auth', 'mustAdmin'])->name('add-employee');
    Route::post('employeedetail', [EmployeeController::class, 'show'])->middleware(['auth', 'mustAdmin'])->name('detail-employee');
    Route::patch('employee/{id}', [EmployeeController::class, 'update'])->middleware(['auth', 'mustAdmin'])->name('update-employee');
    Route::patch('employeeinactive/{id}', [EmployeeController::class, 'inactive'])->middleware(['auth', 'mustAdmin'])->name('inactive-employee');
    Route::get('filteremployee', [EmployeeController::class, 'index'])->name('employee-filter');

    Route::get('shift', [ShiftController::class, 'index'])->middleware(['auth', 'mustAdmin'])->name('shift');
    Route::post('shiftadd', [ShiftController::class, 'store'])->middleware(['auth', 'mustAdmin'])->name('upload-shift');

    Route::get('emergency', [EmergencyController::class, 'index'])->middleware(['auth', 'mustAdmin'])->name('emergency');
    Route::post('save-emergency', [EmergencyController::class, 'store'])->middleware(['auth', 'mustAdmin'])->name('save-emergency');
    Route::post('save-evacuation', [EmergencyController::class, 'storeEvacuation'])->middleware(['auth', 'mustAdmin'])->name('save-evacuation');
    Route::get('filteremergency', [EmergencyController::class, 'index'])->name('emergency-filter');

    Route::get('report', [ReportController::class, 'index'])->middleware('auth')->name('report');
    Route::post('report', [ReportController::class, 'filter'])->middleware('auth')->name('reportfilter');
});
