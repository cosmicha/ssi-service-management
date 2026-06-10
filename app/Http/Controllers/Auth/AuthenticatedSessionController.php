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
    public function create(): View
    {
        session()->forget('url.intended');

        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        $role = auth()->user()->role ?? 'admin';

        if (in_array($role, ['customer', 'customer_admin'])) {
            return redirect('/customer-portal');
        }

        if ($role === 'engineer') {
            return redirect('/engineer');
        }

        return redirect('/dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('url.intended');

        return redirect('/login');
    }
}
