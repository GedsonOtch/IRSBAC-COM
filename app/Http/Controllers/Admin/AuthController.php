<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

               Auth::guard('admin')->user()->update([
            'last_login_at' => now()
        ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'password' => 'Identifiants incorrects'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

       // $request->session()->invalidate();
       //$request->session()->regenerateToken();

        return redirect()->route('login');
    }


public function store(Request $request)
{

 
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'role' => 'required'
    ]);

    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make('#IRSAdmin')
    ]);

    return back()->with(
        'success',
        'Administrateur créé avec succès.'
    );
}

}
