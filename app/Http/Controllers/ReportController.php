<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Leavetype;
use App\Models\Requestleave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userAuth = Auth::user()->roleId;
        $filter = $request->input('Filter');
        // dd($filter);
        $userauth = Auth::user()->role->name;
        // dd($userauth);
        if ($filter == null) {
            // dd($filter);
        } else {
            dd($filter);
        }
        
        if ($userAuth == 1) {
          $datas = Requestleave::where('inactive', '=', '1')
              ->orderBy('id', 'asc')->get();
          return view('pages.report', [
              'menu' => 'Report',
          ])->with('datas', $datas);
        } else {
          $datas = Requestleave::where('inactive', '=', '1')
              ->where('userId', '=', Auth::user()->id)
              ->orderBy('id', 'asc')->get();
          return view('pages.report', [
              'menu' => 'Report',
          ])->with('datas', $datas);
        
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
        $userAuth = Auth::user()->roleId;
        
        $filter = $request->input('Filter');
        
        if ($userAuth == 1) {
          if ($filter <> 'All') {
              $datas = Requestleave::where('inactive', '=', '1')
                  ->where('status', $filter)
                  ->orderBy('id', 'asc')
                  ->get();
          } else {
              $datas = Requestleave::where('inactive', '=', '1')
                  ->orderBy('id', 'asc')
                  ->get();
          }
        } else {
          if ($filter <> 'All') {
              $datas = Requestleave::where('inactive', '=', '1')
                  ->where('userId', '=', Auth::user()->id)
                  ->where('status', $filter)
                  ->orderBy('id', 'asc')
                  ->get();
          } else {
              $datas = Requestleave::where('inactive', '=', '1')
                  ->where('userId', '=', Auth::user()->id)
                  ->orderBy('id', 'asc')
                  ->get();
          }
        }
        
        return view('pages.Report.tblReport', [
            'menu' => 'Report',
        ])->with('datas', $datas);
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
