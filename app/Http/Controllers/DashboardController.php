<?php

namespace App\Http\Controllers;

use App\Models\Requestleave;
use App\Models\User;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::User()->id;
        $ipAddress = $request->ip();
        // dd($ipAddress);
        $status = ['PENDING', 'APPROVED', 'REJECTED', 'CANCEL'];
        return view('pages.dashboard', [
            'menu' => 'Dashboard',
            // 'pending' => Requestleave::where('userId', $id)->where('status', 'PENDING')->count(),
            // 'approve' => Requestleave::where('userId', $id)->where('status', 'APPROVED')->count(),
            // 'reject' => Requestleave::where('userId', $id)->where('status', 'REJECTED')->count(),
            // 'cuti' => Userdetail::where('userId', $id)->first(),
            // 'users' => User::where('username', '<>', 'admin')->where('inactive', '1 ')->count(),
            // 'title' => 'Dashboard'
        ]);
    }
}
