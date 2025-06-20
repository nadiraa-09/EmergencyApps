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

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Record::all();
        return view('pages.report', [
            'menu' => 'Report',
            'employees' => Employee::all(),
            'areas' => Area::all(),
            'lines' => Line::all(),
            'departments' => Department::all(),
            'records' => Record::all(),
        ])->with('datas', $datas);
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

    public function filter(Request $request)
    {
        $query = Record::with([
            'employee.area',
            'employee.department',
            'employee.line',
            'employee.shift'
        ])
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

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $datas = $query->orderBy('id', 'asc')->get();

        return view('pages.report.tblreport')->with('datas', $datas);
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
