<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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
        // Cek apakah ini adalah halaman login publik (bukan admin)
        $isAdminLoginPage = str_contains(url()->previous(), '/admin/login');
        
        // Log untuk debugging
        \Illuminate\Support\Facades\Log::info('Login attempt', [
            'email' => $request->email,
            'is_admin_page' => $isAdminLoginPage,
            'previous_url' => url()->previous(),
            'current_path' => request()->path()
        ]);
        
        // Jika ini adalah halaman login publik dan user mencoba login sebagai admin
        // Kita akan menolak login dan mengarahkan ke halaman login admin
        if (!$isAdminLoginPage) {
            // Cek kredensial tanpa login
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();
            
            if ($user && $user->role === 'admin') {
                return redirect()->route('login')
                    ->with('error', 'Admin harus login melalui halaman admin. Silakan gunakan /admin/login');
            }
        }
        
        $request->authenticate();
        
        $request->session()->regenerate();
        
        $user = Auth::user(); // Ambil user yang sedang login
        
        // Log info user setelah login berhasil
        \Illuminate\Support\Facades\Log::info('User authenticated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'is_admin_page' => $isAdminLoginPage
        ]);
        
        // Arahkan berdasarkan role
        if ($user && $user->role === 'admin') {
            // Admin selalu diarahkan ke panel admin Filament
            \Illuminate\Support\Facades\Log::info('Redirecting admin to /admin');
            
            // Jika login dari halaman admin, gunakan intended
            if ($isAdminLoginPage) {
                return redirect()->intended('/admin');
            }
            
            // Jika tidak, paksa redirect ke admin
            return redirect('/admin');
        }
        
        return redirect()->intended('/'); // User biasa ke halaman utama
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

    protected $redirectTo = '/';
}
