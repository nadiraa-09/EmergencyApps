<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Area;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Perhitungan total hadir per shift
        $shift1 = Employee::whereHas('record', fn($q) => $q->where('status', 'hadir')->where('inactive', 1)->where('curshift', '1'))->count();
        $shift2 = Employee::whereHas('record', fn($q) => $q->where('status', 'hadir')->where('inactive', 1)->where('curshift', '2'))->count();
        $shift3 = Employee::whereHas('record', fn($q) => $q->where('status', 'hadir')->where('inactive', 1)->where('curshift', '3'))->count();
        $shiftN = Employee::whereHas('record', fn($q) => $q->where('status', 'hadir')->where('inactive', 1)->where('curshift', 'N'))->count();

        // Ambil data kehadiran yang aktif
        $employees = Employee::with(['record', 'department', 'area'])
            ->whereHas('record', fn($q) => $q->where('status', 'hadir')->where('inactive', 1))
            ->get();

        // Ambil semua department & area
        $departments = Department::all();
        $areas = Area::all();
        $shifts = ['1', '2', '3', 'N'];

        // Hitung kehadiran per department + shift
        $kehadiranPerDept = [];
        foreach ($departments as $dept) {
            foreach ($shifts as $shift) {
                $jumlah = $employees->filter(function ($e) use ($dept, $shift) {
                    return $e->department && $e->department->id === $dept->id && $e->record?->curshift === $shift;
                })->count();

                $kehadiranPerDept[] = (object)[
                    'department_name' => $dept->name,
                    'curshift' => $shift,
                    'jumlah_hadir' => $jumlah ?: '-',
                ];
            }
        }

        // Ambil master list department & area
        $departments = Department::all();
        $areas = Area::all();
        $shifts = ['1', '2', '3', 'N'];

        // Build kehadiran per department + shift
        $kehadiranPerDept = [];
        foreach ($departments as $dept) {
            foreach ($shifts as $shift) {
                $jumlah = $employees->filter(
                    fn($e) =>
                    $e->department && $e->department->id === $dept->id &&
                        $e->record?->curshift === $shift
                )->count();

                $kehadiranPerDept[] = (object)[
                    'department_name' => $dept->name,
                    'curshift' => $shift,
                    'jumlah_hadir' => $jumlah ?: '-',
                ];
            }
        }

        // Build kehadiran per area + shift
        $kehadiranPerArea = [];
        foreach ($areas as $area) {
            foreach ($shifts as $shift) {
                $jumlah = $employees->filter(
                    fn($e) =>
                    $e->area && $e->area->id === $area->id &&
                        $e->record?->curshift === $shift
                )->count();

                $kehadiranPerArea[] = (object)[
                    'area_name' => $area->name,
                    'curshift' => $shift,
                    'jumlah_hadir' => $jumlah ?: '-',
                ];
            }
        }

        return view('pages.dashboard', [
            'menu' => 'Dashboard',
            'shift1' => $shift1,
            'shift2' => $shift2,
            'shift3' => $shift3,
            'shiftN' => $shiftN,
            'kehadiranPerDept' => $kehadiranPerDept,
            'kehadiranPerArea' => $kehadiranPerArea,
        ]);
    }

    public function filter(Request $request)
    {
        $shiftFilter = $request->input('shift', 'All');

        $departments = Department::all();
        $areas = Area::all();
        $shifts = ['1', '2', '3', 'N'];

        // Ambil semua employee yang aktif hadir
        $employees = Employee::with(['record', 'department', 'area'])
            ->whereHas(
                'record',
                fn($q) =>
                $q->where('status', 'hadir')->where('inactive', 1)
            )->get();

        // Hitung kehadiran per department
        $kehadiranPerDept = [];
        foreach ($departments as $dept) {
            foreach ($shifts as $shift) {
                $jumlah = $employees->filter(
                    fn($e) =>
                    $e->department && $e->department->id === $dept->id &&
                        $e->record?->curshift === $shift
                )->count();

                $kehadiranPerDept[] = (object)[
                    'department_name' => $dept->name,
                    'curshift' => $shift,
                    'jumlah_hadir' => $jumlah ?: '-',
                ];
            }
        }

        // Hitung kehadiran per area
        $kehadiranPerArea = [];
        foreach ($areas as $area) {
            foreach ($shifts as $shift) {
                $jumlah = $employees->filter(
                    fn($e) =>
                    $e->area && $e->area->id === $area->id &&
                        $e->record?->curshift === $shift
                )->count();

                $kehadiranPerArea[] = (object)[
                    'area_name' => $area->name,
                    'curshift' => $shift,
                    'jumlah_hadir' => $jumlah ?: '-',
                ];
            }
        }

        return response()->json([
            'department' => view('pages.dashboard.tbldepartment', [
                'kehadiranPerDept' => $kehadiranPerDept,
                'shiftFilter' => $shiftFilter,
            ])->render(),
            'area' => view('pages.dashboard.tblarea', [
                'kehadiranPerArea' => $kehadiranPerArea,
                'shiftFilter' => $shiftFilter,
            ])->render(),
        ]);
    }
}
