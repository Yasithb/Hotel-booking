<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is now handled in routes/web.php
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Log the successful login
            \Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role ?? 'guest',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirect based on user role or intended URL
            $intendedUrl = $request->session()->get('url.intended', $this->getRedirectPath($user));
            
            return redirect()->intended($intendedUrl)->with('success', 'Welcome back, ' . $user->first_name . '!');
        }

        // Log failed login attempt
        \Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            \Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Get the redirect path based on user role.
     */
    protected function getRedirectPath($user)
    {
        $role = $user->role ?? 'guest';
        
        switch ($role) {
            case 'admin':
                return route('dashboard');
            case 'staff':
                return route('dashboard');
            case 'guest':
            default:
                return route('dashboard');
        }
    }

    /**
     * Handle demo login for testing purposes.
     */
    public function demoLogin(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:admin,staff,guest']
        ]);

        $demoCredentials = [
            'admin' => ['email' => 'admin@hotel.com', 'password' => 'password123'],
            'staff' => ['email' => 'staff@hotel.com', 'password' => 'password123'],
            'guest' => ['email' => 'guest@hotel.com', 'password' => 'password123']
        ];

        $credentials = $demoCredentials[$request->type];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            return redirect()->route('dashboard')->with('success', 'Welcome to the demo, ' . $user->first_name . '!');
        }

        return back()->withErrors(['email' => 'Demo login failed. Please contact support.']);
    }

    /**
     * Check if user account is active and verified.
     */
    protected function authenticated(Request $request, $user)
    {
        // Check if user account is active (if you have an 'active' field)
        if (method_exists($user, 'isActive') && !$user->isActive()) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.'
            ]);
        }

        // Check if email is verified (if you have email verification)
        if (method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended($this->getRedirectPath($user));
    }
}