<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'telepon' => 'required|numeric',
            'password' => 'required|string',
        ]);

        $user = User::where('telepon', $request->telepon)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'telepon' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Ganti dengan route untuk dashboard
        } elseif ($user->role === 'cleaning_service') {
            return redirect()->route('user.home'); // Ganti dengan route untuk home
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna

        $request->session()->invalidate(); // Menghapus session
        $request->session()->regenerateToken(); // Regenerasi CSRF token

        return redirect()->route('login'); // Redirect ke halaman login
    }
}
