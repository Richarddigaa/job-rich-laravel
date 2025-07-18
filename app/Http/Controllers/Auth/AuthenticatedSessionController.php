<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole('applicant')) { // role pelamar
            return redirect()->route('applicant.dashboard');
        } elseif ($user->hasRole('company')) { // role perusahaan
            return redirect()->route('company.dashboard');
        } elseif ($user->hasRole('admin')) { // role admin
            return redirect()->route('admin.dashboard');
        } else {
            // untuk role yang tidak terdaftar
            return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
