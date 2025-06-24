<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Area;
use App\Models\Line;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $area = $request->query('area', 'All');

        $query = Employee::with(['area'])->where('inactive', '1');

        if ($area !== 'All') {
            $query->where('areaId', $area); // assuming Employee.areaId exists
        }

        $datas = $query->orderBy('badgeid', 'asc')->latest()->paginate(1000000);

        if ($request->ajax()) {
            return view('pages.employee.tblemployee')
                ->with('datas', $datas)
                ->render();
        }

        return view('pages.employee', [
            'menu' => 'Master Data',
            'areas' => Area::all(),
            'departments' => Department::all(),
            'lines' => Line::all(),
            'roles' => Role::all(),
            'users' => User::all(),
            'datas' => $datas,
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
        $data = $request->all();
        $validatedData = $request->validate([
            'badgeid' => ['required', 'min:5', 'max:8'],
            'name' => ['required', 'max:255'],
            'areaId' => ['required'],
            'departmentId' => ['required'],
            'lineId' => ['required'],
            'roleId' => ['required'],
        ]);

        $validatedData['inactive'] = '1';
        $validatedData['areaId'] = $data['areaId'];
        $validatedData['departmentId'] = $data['departmentId'];
        $validatedData['lineId'] = $data['lineId'];
        $validatedData['roleId'] = $data['roleId'];
        $validatedData['createdBy'] = Auth::user()->username;
        $validatedData['updatedBy'] = Auth::user()->username;

        try {
            Employee::create($validatedData);
            return redirect()->route('employee')->with('success', 'Registrasi Employee berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registrasi Gagal, hubungi administrator!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->input('id');

        $employee = Employee::where('badgeid', $id)->first();

        if (!$employee) {
            return response()->json([
                'message' => 'Employee tidak ditemukan'
            ], 404);
        }

        $user = User::where('username', $id)->with('role')->first();

        return view('pages.employee.editemployee', [
            'menu' => 'Master Data',
            'data' => $employee,
            'user' => $user, // boleh null, blade harus aman
            'areas' => Area::all(),
            'departments' => Department::all(),
            'lines' => Line::all(),
            'roles' => Role::all(),
        ]);
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
    // app/Http/Controllers/EmployeeController.php
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'areaId' => 'required|exists:areas,id',
            'departmentId' => 'required|exists:departments,id',
            'lineId' => 'required|exists:lines,id',
            'roleId' => 'required|exists:roles,id',
        ]);

        $validatedData = Employee::where('badgeid', $id)->first();

        if (!$validatedData) {
            return redirect()->back()->withErrors(['badgeid' => 'Employee not found.']);
        }

        $validatedData->name = $validated['name'];
        $validatedData->areaId = $validated['areaId'];
        $validatedData->departmentId = $validated['departmentId'];
        $validatedData->lineId = $validated['lineId'];
        $validatedData->roleId = $validated['roleId'];
        $validatedData->updatedBy = Auth::user()->username;
        $validatedData->updated_at = now();
        $validatedData->save();

        return redirect()->route('employee')->with('success', 'Success update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inactive(Request $request, string $id)
    {
        $data = $request->all();
        // dd($data);
        $user = Employee::find($id);
        $user->inactive = '0';
        $user->save();
        return redirect()->route('user')->with('success', 'success inactive');
    }
}
