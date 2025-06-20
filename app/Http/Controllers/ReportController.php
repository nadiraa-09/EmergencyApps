<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Employee;
use App\Models\Area;
use App\Models\Line;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Record;
use App\Models\Leavetype;
use App\Models\Requestleave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now();
        $month = $today->month;
        $year = $today->year;

        $query = Record::with([
            'employee.area',
            'employee.department',
            'employee.line',
            'employee.shift'
        ])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereHas('employee');

        $records = $query->get()->groupBy('badgeid');

        return view('pages.report', [
            'menu' => 'Report',
            'employees' => Employee::all(),
            'areas' => Area::all(),
            'departments' => Department::all(),
            'lines' => Line::all(),
            'records' => $records,
            'month' => $month,
            'year' => $year,
            'daysInMonth' => $today->daysInMonth,
        ]);
    }


    public function filter(Request $request)
    {
        $month = (int) $request->input('month');
        $year = (int) $request->input('year');

        $query = Record::with([
            'employee.area',
            'employee.department',
            'employee.line',
            'employee.shift'
        ])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereHas('employee');

        if ($request->filled('area_id') && $request->area_id !== 'All') {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('areaId', $request->area_id);
            });
        }

        if ($request->filled('department_id') && $request->department_id !== 'All') {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('departmentId', $request->department_id);
            });
        }

        $records = $query->get()->groupBy('badgeid');

        // Hitung jumlah hari di bulan untuk blade
        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

        return view('pages.report.tblreport', [
            'records' => $records,
            'month' => $month,
            'year' => $year,
            'daysInMonth' => $daysInMonth,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
