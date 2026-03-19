<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ── Form Login ────────────────────────────────────────────────
    public function showLogin()
    {
        return auth()->check()
            ? redirect()->route('dashboard')
            : view('auth.login');
    }

    // ── Proses Login ──────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string',
        ]);

        // ── Rate Limiting via file cache (tidak butuh tabel cache) ─
        $key     = 'login_attempts_' . sha1($request->ip());
        $maxTry  = 5;
        $decayS  = 60; // 1 menit

        $attempts = Cache::store('file')->get($key, 0);

        if ($attempts >= $maxTry) {
            $ttl = Cache::store('file')->getStore()->get($key . '_ttl') ?? $decayS;
            throw ValidationException::withMessages([
                'username' => "Terlalu banyak percobaan login. Coba lagi dalam {$decayS} detik.",
            ]);
        }

        // ── Coba login via username atau email ────────────────────
        $field      = str_contains($request->username, '@') ? 'email' : 'username';
        $credentials = [
            $field      => $request->username,
            'password'  => $request->password,
            'is_active' => true,
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Tambah hitungan gagal
            Cache::store('file')->put($key, $attempts + 1, $decayS);

            $sisaTry = $maxTry - ($attempts + 1);
            $pesan   = $sisaTry > 0
                ? "Username / password salah, atau akun tidak aktif. Sisa percobaan: {$sisaTry}."
                : "Terlalu banyak percobaan. Akses dikunci {$decayS} detik.";

            throw ValidationException::withMessages(['username' => $pesan]);
        }

        // ── Login berhasil ────────────────────────────────────────
        Cache::store('file')->forget($key); // reset counter

        auth()->user()->update(['last_login_at' => now()]);
        $request->session()->regenerate(); // cegah session fixation

        AuditLog::catat('login', 'User berhasil login dari IP: ' . $request->ip());

        return redirect()->intended(route('dashboard'));
    }

    // ── Logout ────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        AuditLog::catat('logout', 'User logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout. Sampai jumpa!');
    }
}
