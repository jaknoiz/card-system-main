<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Redirect the user to their own contact card if user role is 'user'
        if ($user->role === 'admin') {
            return redirect()->route('contacts.index');  // Admin dashboard
        } else {
            return redirect()->route('contacts.mycard');  // User's own business card page
        }
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
