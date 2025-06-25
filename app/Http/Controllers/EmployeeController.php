<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Area;
use App\Models\Line;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
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
            'roles' => Role::whereNotIn('id', [1, 2])->get(),
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
            'roleId' => 'required|exists:roles,id',
        ]);

        $employee = Employee::where('badgeid', $id)->first();

        if (!$employee) {
            return redirect()->back()->withErrors(['badgeid' => 'Employee not found.']);
        }

        $user = User::where('username', $id)->first();

        if ($user) {
            // Update user role jika user sudah ada
            $user->roleId = $validated['roleId'];
            $user->updatedBy = Auth::user()->username;
            $user->updated_at = now();
            $user->save();
        } else {
            // Buat user baru dengan data dari employee
            try {
                User::create([
                    'username' => $employee->badgeid,
                    'name' => $employee->name,
                    'password' => Hash::make($employee->badgeid),
                    'roleId' => $validated['roleId'],
                    'departmentId' => $employee->departmentId,
                    'inactive' => '1',
                    'createdBy' => Auth::user()->username,
                    'updatedBy' => Auth::user()->username,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal membuat user baru: ' . $e->getMessage());
            }
        }

        return redirect()->route('employee')->with('success', 'User berhasil diperbarui.');
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
        $employee = Employee::find($id);

        if (!$employee) {
            return redirect()->back()->withErrors(['badgeid' => 'Employee tidak ditemukan.']);
        }

        $employee->inactive = '0';
        $employee->save();

        $user = User::where('username', $id)->first();
        if ($user) {
            $user->inactive = '0';
            $user->save();
        }

        return redirect()->route('user')->with('success', 'Berhasil menonaktifkan employee dan user.');
    }
}
