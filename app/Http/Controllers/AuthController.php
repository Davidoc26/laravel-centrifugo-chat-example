<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->only(['name', 'password']))) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return redirect()->route('home')->withErrors(['authentication' => 'Wrong username or password']);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('home');
    }

}
