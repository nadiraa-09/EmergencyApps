<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Employee;
use App\Models\Area;
use App\Models\Line;
use App\Models\Role;
use App\Models\Department;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuth = Auth::user()->roleId;
        if ($userAuth == 5) {
            $departmentId = Auth::user()->departmentId;

            $datas = Shift::with('employee')
                ->where('inactive', '1')
                ->whereHas('employee', function ($q) use ($departmentId) {
                    $q->where('departmentId', $departmentId);
                })
                ->orderBy('badgeid', 'asc')
                ->latest()
                ->paginate(1000000);

            $totalEmployee = $datas->unique('badgeid')->count();
        } else {
            $datas = Shift::where('inactive', '1')
                ->orderBy('badgeid', 'asc')
                ->latest()
                ->paginate(1000000);

            $totalEmployee = $datas->unique('badgeid')->count();
        }

        return view('pages.shift', [
            'menu' => 'Shift Employee',
            'employees' => Employee::all(),
            'datas' => $datas,
            'totalEmployee' => $totalEmployee,
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
        $request->validate([
            'shiftfile' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('shiftfile');
            $rows = Excel::toArray([], $file);
            $data = $rows[0] ?? [];

            unset($data[0]); // Remove header

            if (empty($data)) {
                return redirect()->back()->with('error', 'Excel file is empty.');
            }

            $firstDeptName = trim($data[1][2] ?? '');
            $department = Department::firstOrCreate(['name' => $firstDeptName]);

            Employee::where('departmentId', $department->id)->update(['inactive' => '0']);

            $errorRows = [];
            $successCount = 0;

            foreach ($data as $i => $row) {
                if (count($row) < 3 || empty(trim($row[0]))) {
                    continue;
                }

                $badgeid = trim($row[0]);
                $name = trim($row[1]);
                $deptName = trim($row[2]);
                $areaName = trim($row[3]);
                $lineName = trim($row[4] ?? '');
                $shift = trim($row[5] ?? '');
                $curshift = trim($row[6] ?? '');

                $rowErrors = [];
                if (empty($badgeid)) $rowErrors[] = 'Badge ID kosong';
                if (empty($name)) $rowErrors[] = 'Nama kosong';
                if (empty($deptName)) $rowErrors[] = 'Department kosong';
                if (empty($areaName)) $rowErrors[] = 'Area kosong';
                if (empty($shift)) $rowErrors[] = 'Shift kosong';
                if (empty($curshift)) $rowErrors[] = 'Current Shift kosong';

                if (!empty($rowErrors)) {
                    $errorRows[] = 'Baris ' . ($i + 2) . ': ' . implode(', ', $rowErrors);
                    continue;
                }

                $department = Department::firstOrCreate(['name' => $deptName]);
                $area = Area::firstOrCreate(['name' => $areaName]);
                $line = !empty($lineName) ? Line::firstOrCreate(['name' => $lineName]) : null;

                Employee::updateOrCreate(
                    ['badgeid' => $badgeid, 'departmentId' => $department->id],
                    [
                        'name' => $name,
                        'areaId' => $area->id,
                        'lineId' => $line?->id,
                        'inactive' => '1',
                        'createdBy' => Auth::user()->username,
                        'updatedBy' => Auth::user()->username,
                    ]
                );

                Shift::updateOrCreate(
                    ['badgeid' => $badgeid],
                    [
                        'shift' => $shift,
                        'curshift' => $curshift,
                        'inactive' => '1',
                        'createdBy' => Auth::user()->username,
                        'updatedBy' => Auth::user()->username,
                    ]
                );

                $successCount++;
            }

            if (!empty($errorRows)) {
                return redirect()->back()->with('error', 'Import failed on several rows:<br>' . implode('<br>', $errorRows));
            }

            return redirect()->back()->with('success', "Shift data imported successfully. Total successful employees: {$successCount}");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Import data failed. Please double check your Excel file format or contact admin.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
