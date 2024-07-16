<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $title = "Users";
        $subtitle = "Halaman ini menampilkan daftar semua pengguna yang ada di dalam aplikasi.";
        return view('dashboard.users', compact('users', 'title', 'subtitle'));
    }

    public function store(Request $request)
    {
        $userData = $request->except('_token');
        $userData['password'] = Hash::make($request->password);
        User::create($userData);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->only('name', 'email', 'level');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function export()
    {
        $fileName = 'users_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new UserExport, $fileName);
    }

    public function show()
    {
        $fileName = 'users_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new UserExport, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new UserImport, $request->file('file'));

        return redirect()->route('users.index')->with('success', 'Users imported successfully.');
    }
}
