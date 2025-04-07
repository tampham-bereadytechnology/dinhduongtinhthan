<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class CustomLoginController extends Controller
{
    //
    public function Login(Request $request)
    {
        return view('login');
    }
    public function checkUser(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                'g-recaptcha-response' => 'required',
            ],
            [
                'g-recaptcha-response.required' => 'Vui lòng xác nhận bạn không phải là robot',
            ]
        );
        // Check email and password
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email không đúng.', 'password' => 'Password không đúng.'])
                ->withInput();
        }
        // Check captcha
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(), // Tùy chọn: IP người dùng
        ]);
        $result = $response->json();
        if (!$result['success']) {
            return back()->withErrors(['captcha' => 'Xác nhận reCAPTCHA thất bại.']);
        }
        // Login
        $request->session()->regenerate();
        return redirect('/admin');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
