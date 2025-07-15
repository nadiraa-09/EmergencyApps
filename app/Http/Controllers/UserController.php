<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Area;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::where('inactive', '1')->orderBy('username', 'asc')->latest()->paginate(1000000);
        return view('pages.user', [
            'menu' => 'Master Data',
            // 'title' => 'User',
            'roles' => Role::all(),
            'areas' => Area::all(),
            'departments' => Department::all(),
        ])->with('datas', $datas);
    }

    public function indexleave()
    {
        $datas = User::with('userdetail')
            ->where('inactive', '1')
            ->orderBy('username', 'asc')
            ->latest()
            ->paginate(1000000);

        return view('pages.leaveuser', [
            'menu' => 'Master Data',
            'roles' => Role::all(),
            'departments' => Department::all(),
            'datas' => $datas,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'min:5', 'max:8'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:5', 'max:255'],
            'roleId' => ['required'],
            'departmentId' => ['required'],
            'areaId' => ['required'],
        ]);

        try {
            User::create([
                'username' => $validatedData['username'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'roleId' => $validatedData['roleId'],
                'departmentId' => $validatedData['departmentId'],
                'areaId' => $validatedData['areaId'],
                'inactive' => '1',
                'createdBy' => Auth::user()->username,
                'updatedBy' => Auth::user()->username,
            ]);

            return redirect()->route('user')->with('success', 'Registrasi User berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registrasi Gagal, hubungi administrator!');
        }
    }


    public function show(Request $request)
    {
        $params = $request->all();
        $id = $params["id"];
        $datas = User::where('id', $id)->first();

        if (!$datas) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return view('pages.user.editUser', [
            'menu' => 'Master Data',
            'roles' => Role::all(),
            'areas' => Area::all(),
            'departments' => Department::all(),
        ])->with('data', $datas);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'username' => ['required', 'min:5', 'max:8'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'roleId' => ['required'],
            'departmentId' => ['required'],
            'areaId' => ['required'],
        ]);

        $user = User::findOrFail($id);

        $user->username = $validated['username'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->roleId = $validated['roleId'];
        $user->departmentId = $validated['departmentId'];
        $user->areaId = $validated['areaId'];
        $user->updatedBy = Auth::user()->username;
        $user->updated_at = now();
        $user->save();

        return redirect()->route('user')->with('success', 'Success update');
    }

    public function inactive(Request $request, string $id)
    {
        $data = $request->all();
        // dd($data);
        $user = User::find($id);
        $user->inactive = '0';
        $user->save();
        return redirect()->route('user')->with('success', 'success inactive');
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'password' => 'required',
        ]);

        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return response()->json(['success' => true]);
    }

    public function destroy(string $id)
    {
        //
    }
}
