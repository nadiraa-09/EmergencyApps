<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $roleId = Auth::user()->roleId;

            if (in_array($roleId, [3, 4])) {
                return redirect('/pages/emergency')->with('success', 'Login Berhasil!');
            }

            if ($roleId == 5) {
                return redirect('/pages/shift');
            }

            return redirect()->intended('/pages/dashboard')->with('success', 'Login Berhasil!');
        }

        return back()->with('error', 'Login Gagal!');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}
