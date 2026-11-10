<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Akun demo hardcoded, tanpa database.
    private const USERNAME = 'valen';
    private const PASSWORD = 'kalenku123';

    public function form(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('username')) {
            return redirect()->route('beranda');
        }

        $akunDemo = ['username' => self::USERNAME, 'password' => self::PASSWORD];

        return view('login', compact('akunDemo'));
    }

    public function proses(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Isi username kamu.',
            'password.required' => 'Isi password kamu.',
        ]);

        $cocok = strtolower(trim($data['username'])) === self::USERNAME
            && $data['password'] === self::PASSWORD;

        if (! $cocok) {
            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();
        $request->session()->put('username', self::USERNAME);

        return redirect()->route('beranda');
    }

    public function keluar(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
