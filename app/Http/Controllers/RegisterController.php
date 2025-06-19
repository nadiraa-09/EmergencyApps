<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'min:5', 'max:8'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'min:5', 'max:255'],
            'inactive' => '1',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['inactive'] = '1';
        $validatedData['status'] = 'P';
        $validatedData['roleId'] = '1';
        $validatedData['joinDate'] = '2019-05-07';
        $validatedData['departmentId'] = '1';
        $validatedData['createdBy'] = 'System';
        $validatedData['updatedBy'] = 'System';
        User::create($validatedData);
        // $request->session()->flash('success', 'Registration Successfull! Please login');
        return redirect('/login')->with('success', 'Registration Successfull! Please login');
    }
}
