<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Area;
use App\Models\Record;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $shifts = Record::where('inactive', 1)
            ->whereIn('status', ['Hadir', 'Masuk setengah hari', 'Absen'])
            ->distinct()
            ->pluck('curshift')
            ->toArray();

        $shiftData = [];
        foreach ($shifts as $s) {
            $total = Employee::whereHas(
                'record',
                fn($q) =>
                $q->where('curshift', $s)->where('inactive', 1)
            )->count();

            $hadir = Employee::whereHas(
                'record',
                fn($q) =>
                $q->where('curshift', $s)
                    ->whereIn('status', ['Hadir', 'Masuk setengah hari'])
                    ->where('inactive', 1)
            )->count();

            $absen = Employee::whereHas(
                'record',
                fn($q) =>
                $q->where('curshift', $s)
                    ->where('status', 'Absen')
                    ->where('inactive', 1)
            )->count();

            $shiftData[$s] = compact('total', 'hadir', 'absen');
        }

        $employees = Employee::with(['record', 'department', 'area'])
            ->whereHas(
                'record',
                fn($q) =>
                $q->whereIn('status', ['Hadir', 'Masuk setengah hari'])
                    ->where('inactive', 1)
            )->get();

        $departments = Department::all();
        $areas = Area::all();

        // === Kehadiran Per Department ===
        $kehadiranPerDept = [];
        foreach ($departments as $dept) {
            $found = false;
            foreach ($shifts as $shift) {
                $filtered = $employees->filter(
                    fn($e) =>
                    $e->department && $e->department->id === $dept->id &&
                        $e->record?->curshift === $shift
                );

                $jumlah_hadir = $filtered->count();
                $total_employee = Employee::where('departmentId', $dept->id)
                    ->whereHas(
                        'record',
                        fn($q) =>
                        $q->where('curshift', $shift)->where('inactive', 1)
                    )->count();

                $jumlah_absen = max($total_employee - $jumlah_hadir, 0);

                if ($jumlah_hadir > 0 || $total_employee > 0) {
                    $kehadiranPerDept[] = (object)[
                        'department_name' => $dept->name,
                        'curshift' => $shift,
                        'total_employee' => $total_employee,
                        'jumlah_hadir' => $jumlah_hadir,
                        'jumlah_absen' => $jumlah_absen,
                        'is_empty' => $jumlah_hadir === 0,
                    ];
                    $found = true;
                }
            }

            if (! $found) {
                $total_employee = Employee::where('departmentId', $dept->id)
                    ->whereHas('record', fn($q) => $q->where('inactive', 1))
                    ->count();

                $kehadiranPerDept[] = (object)[
                    'department_name' => $dept->name,
                    'curshift' => '-',
                    'total_employee' => $total_employee,
                    'jumlah_hadir' => 0,
                    'jumlah_absen' => $total_employee,
                    'is_empty' => true,
                ];
            }
        }

        // === Kehadiran Per Area ===
        $kehadiranPerArea = [];
        foreach ($areas as $area) {
            $found = false;
            foreach ($shifts as $shift) {
                $filtered = $employees->filter(
                    fn($e) =>
                    $e->area && $e->area->id === $area->id &&
                        $e->record?->curshift === $shift
                );

                $jumlah_hadir = $filtered->count();
                $total_employee = Employee::where('areaId', $area->id)
                    ->whereHas(
                        'record',
                        fn($q) =>
                        $q->where('curshift', $shift)->where('inactive', 1)
                    )->count();

                $jumlah_absen = max($total_employee - $jumlah_hadir, 0);

                if ($jumlah_hadir > 0 || $total_employee > 0) {
                    $kehadiranPerArea[] = (object)[
                        'area_name' => $area->name,
                        'curshift' => $shift,
                        'total_employee' => $total_employee,
                        'jumlah_hadir' => $jumlah_hadir,
                        'jumlah_absen' => $jumlah_absen,
                        'is_empty' => $jumlah_hadir === 0,
                    ];
                    $found = true;
                }
            }

            if (! $found) {
                $total_employee = Employee::where('areaId', $area->id)
                    ->whereHas('record', fn($q) => $q->where('inactive', 1))
                    ->count();

                $kehadiranPerArea[] = (object)[
                    'area_name' => $area->name,
                    'curshift' => '-',
                    'total_employee' => $total_employee,
                    'jumlah_hadir' => 0,
                    'jumlah_absen' => $total_employee,
                    'is_empty' => true,
                ];
            }
        }

        return view('pages.dashboard', [
            'menu' => 'Dashboard',
            'shiftData' => $shiftData,
            'kehadiranPerDept' => $kehadiranPerDept,
            'kehadiranPerArea' => $kehadiranPerArea,
        ]);
    }
}
