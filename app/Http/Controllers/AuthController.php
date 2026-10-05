<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // صفحة تسجل الدخول
    public function showLogin()
    {
        return view('auth.login');
    }

    // معالجة تسجيل الدخول اليدوي
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('posts.index')->with('success', 'مرحباً بك مجدداً!');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ]);
    }

    // صفحة إنشاء حساب
    public function showRegister()
    {
        return view('auth.register');
    }

    // معالجة إنشاء حساب جديد
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('posts.index')->with('success', 'تم إنشاء الحساب وتسجيل الدخول بنجاح!');
    }

    // تسجيل الخروج اليدوي
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}