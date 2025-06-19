<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Department;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Record::where('inactive', '1')->orderBy('cardid', 'asc')->latest()->paginate(1000000);
        return view('pages.emergencyrecord', [
            'menu' => 'Emergency Record',
            // 'title' => 'User',
            'employee' => Employee::all(),
            'roles' => Role::all(),
            'departments' => Department::all(),
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
    public function storein(Request $request)
    {
        // Validasi input
        $request->validate([
            'cardid' => 'required|string|max:255',
        ]);

        try {
            // Simpan data
            Record::create([
                'cardid' => $request->cardid,
                'status' => 'IN',
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Card recorded successfully.');
        } catch (\Exception $e) {
            // Tangani error sistem/database, redirect dengan pesan error
            return redirect()->back()->with('error', 'Failed to record card. Please try again.');
        }
    }

    public function storeout(Request $request)
    {
        // Validasi input
        $request->validate([
            'cardid' => 'required|string|max:255',
        ]);

        try {
            // Simpan data
            Record::create([
                'cardid' => $request->cardid,
                'status' => 'OUT',
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Card recorded successfully.');
        } catch (\Exception $e) {
            // Tangani error sistem/database, redirect dengan pesan error
            return redirect()->back()->with('error', 'Failed to record card. Please try again.');
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
