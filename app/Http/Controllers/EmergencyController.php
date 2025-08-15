<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Area;
use App\Models\Line;
use App\Models\Role;
use App\Models\Record;
use App\Models\Evacuation;
use App\Models\Shift;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Department;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shift = $request->query('shift', 'All');
        $line = $request->query('line', 'All');

        $userAuth = Auth::user()->roleId;
        if ($userAuth == 3 || $userAuth == 4) {
            // If the user is a supervisor or manager, filter by their department
            $areaId = Auth::user()->areaId;
            $query = Employee::with(['shift', 'line'])
                ->where('inactive', '1')
                ->where('areaId', $areaId);
        } else {
            $query = Employee::with(['shift', 'line'])->where('inactive', '1');
        }

        if ($shift !== 'All') {
            $query->whereHas('shift', function ($q) use ($shift) {
                $q->where('curshift', $shift);
            });
        }

        if ($line !== 'All') {
            $query->where('lineId', $line);
        }

        $datas = $query->orderByRaw("
    CASE 
        WHEN badgeid REGEXP '^[0-9]' THEN 1
        ELSE 0
    END ASC,
    badgeid ASC
")->paginate(1000000);

        // Hitung total karyawan, hadir, dan tidak hadir
        $totalEmployee = $datas->unique('badgeid')->count();
        $totalEmployeeHadir = $datas->filter(function ($data) {
            return in_array($data->record?->status ?? '', ['Hadir', 'Masuk setengah hari']);
        })->count();

        $totalEmployeeTidakHadir = $datas->filter(function ($data) {
            return ($data->record?->status ?? '') === 'Absen';
        })->count();

        if ($request->ajax()) {
            return response()->json([
                'daily' => view('pages.emergency.tbldailyattendace', compact('datas'))->render(),
                'evacuation' => view('pages.emergency.tblevacuation', compact('datas'))->render(),
                'totalEmployeeFiltered' => $totalEmployee,
                'totalEmployeeHadir' => $totalEmployeeHadir,
                'totalEmployeeTidakHadir' => $totalEmployeeTidakHadir,
            ]);
        }

        return view('pages.emergencyrecord', [
            'menu' => 'Evacuation Attendance',
            'areas' => Area::all(),
            'lines' => Line::all(),
            'roles' => Role::all(),
            'shifts' => Shift::all(),
            'records' => Record::all(),
            'evacuations' => Evacuation::all(),
            'departments' => Department::all(),
            'datas' => $datas,
            'totalEmployee' => $totalEmployee,
            'totalEmployeeHadir' => $totalEmployeeHadir,
            'totalEmployeeTidakHadir' => $totalEmployeeTidakHadir,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'checklist' => 'required|array',
                'checklist.*.badgeid' => 'required|string',
                'checklist.*.status' => 'required|string',
                'checklist.*.inactive' => 'required|boolean',
                'checklist.*.remark' => 'nullable|string|max:255',
                'checklist.*.curshift' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Data Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            foreach ($data['checklist'] as $item) {
                Record::where('badgeid', $item['badgeid'])
                    ->where('inactive', 1)
                    ->update([
                        'status' => $item['status'],
                        'inactive' => $item['inactive'],
                        'remark' => $item['remark'] ?? null,
                        'curshift' => $item['curshift'],
                        'updatedBy' => Auth::user()->username,
                    ]);
            }

            return response()->json(['message' => 'Success saving emergency record'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeEvacuation(Request $request)
    {
        try {
            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'checklist' => 'required|array',
                'checklist.*.badgeid' => 'required|string',
                'checklist.*.status' => 'required|string',
                'checklist.*.inactive' => 'required|boolean',
                'checklist.*.remark' => 'nullable|string|max:255',
                'checklist.*.curshift' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Data Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            foreach ($data['checklist'] as $item) {
                Evacuation::where('badgeid', $item['badgeid'])
                    ->where('inactive', 1)
                    ->update([
                        'status' => $item['status'],
                        'inactive' => $item['inactive'],
                        'remark' => $item['remark'] ?? null,
                        'curshift' => $item['curshift'],
                        'updatedBy' => Auth::user()->username,
                    ]);
            }

            return response()->json(['message' => 'Success saving evacuation record'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
