<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     public function index() {
        return view('login',[
            'title' => 'login'
        ]);
    }

    public function login(Request $request) {
        
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ],[
            'name.required' => 'username wajib diisi',
            'password.required' => 'password wajib diisi'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'name' => 'username atau password salah.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
