<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ✅ Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin');
            } else {
                return redirect()->route('officer.dashboard')->with('success', 'Login berhasil sebagai Officer');
            }
        }

        return back()->withErrors(['name' => 'Name atau password salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
