<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is now handled in routes/web.php
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Log the successful registration
        \Log::info('New user registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Auto-login the user after registration
        Auth::login($user);

        // Send welcome email (if you want to implement this later)
        // $this->sendWelcomeEmail($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to Hotel Booking System, ' . $user->first_name . '! Your account has been created successfully.');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:20', 'regex:/^[\+]?[0-9\s\-\(\)]+$/'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'role' => ['required', 'in:guest,staff,admin'],
            'terms' => ['required', 'accepted'],
            'newsletter' => ['nullable', 'boolean']
        ], [
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.regex' => 'Last name can only contain letters and spaces.',
            'phone_number.regex' => 'Please enter a valid phone number.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'You must agree to the Terms of Service.',
            'role.in' => 'Please select a valid account type.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'nationality' => $data['nationality'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'newsletter_subscribed' => $data['newsletter'] ?? false,
            'email_verified_at' => now(), // Auto-verify for demo purposes
        ]);
    }

    /**
     * Handle quick guest registration for bookings.
     */
    public function quickRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'guest',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully!',
            'user' => [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email
            ]
        ]);
    }

    /**
     * Check if email is already taken.
     */
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $exists = User::where('email', $request->email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email is already taken' : 'Email is available'
        ]);
    }

    /**
     * Generate username suggestions based on name.
     */
    public function suggestUsername(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);

        $baseName = strtolower($request->first_name . $request->last_name);
        $suggestions = [];
        
        // Clean the base name
        $baseName = preg_replace('/[^a-z0-9]/', '', $baseName);
        
        // Generate suggestions
        for ($i = 0; $i < 5; $i++) {
            if ($i === 0) {
                $suggestion = $baseName;
            } else {
                $suggestion = $baseName . rand(10, 999);
            }
            
            // Check if username exists (if you have username field)
            $suggestions[] = $suggestion;
        }

        return response()->json(['suggestions' => $suggestions]);
    }

    /**
     * Send welcome email to new user.
     */
    protected function sendWelcomeEmail($user)
    {
        // Implement welcome email functionality
        // Mail::to($user->email)->send(new WelcomeEmail($user));
    }

    /**
     * Handle social media registration (future implementation).
     */
    public function socialRegister(Request $request, $provider)
    {
        // Implement social media registration (Google, Facebook, etc.)
        // This would integrate with Laravel Socialite
        return response()->json([
            'message' => 'Social registration not implemented yet',
            'provider' => $provider
        ]);
    }
}