<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Visitor;
use App\Models\Shift;
use App\Models\Employee;
use App\Models\Record;


class VisitorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->name;
        $username = Auth::user()->username;
        $areaId = Auth::user()->areaId;

        Visitor::create([
            'name'      => $name,
            'areaId'    => $areaId,
            'inactive'  => 1,
            'createdBy' => $username,
            'updatedBy' => $username,
        ]);

        Record::create([
            'badgeid'   => $name,
            'name'      => $name,
            'inactive'  => 1,
            'createdBy' => $username,
            'updatedBy' => $username,
        ]);

        Shift::create([
            'badgeid'   => $name,
            'shift'     => 'Normal',
            'curshift'  => 'N',
            'inactive'  => 1,
            'createdBy' => $username,
            'updatedBy' => $username,
        ]);

        Employee::updateOrCreate(
            ['badgeid' => $name],
            [
                'name'      => $name,
                'areaId'    => $areaId,
                'inactive'  => 1,
                'createdBy' => $username,
                'updatedBy' => $username,
            ]
        );

        return redirect()->back()->with('success', 'Visitor berhasil ditambahkan.');
    }

    public function destroy(Visitor $visitor)
    {
        $badgeid = $visitor->name;
        if ($visitor) {
            $visitor->inactive = 0;
            $visitor->save();
        }

        $record = Record::where('badgeid', $badgeid)->first();
        if ($record) {
            $record->inactive = 0;
            $record->save();
        }

        $shift = Shift::where('badgeid', $badgeid)->first();
        if ($shift) {
            $shift->inactive = 0;
            $shift->save();
        }

        $employee = Employee::where('badgeid', $badgeid)->first();
        if ($employee) {
            $employee->inactive = 0;
            $employee->save();
        }

        return redirect()->back()->with('success', 'Visitor dan data terkait berhasil dinonaktifkan.');
    }
}
