<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\LogService;

class Authcontroller extends Controller
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Invalid email or password']);
        }

        $role = $user->role;

        try {
            if ($role === 'ADMIN') {
                auth()->login($user);
                return redirect()->route('admin.dashboard')->with('success', 'Login successful');
            } elseif ($role === 'USER') {
                auth()->login($user);
                return redirect()->route('user.home')->with('success', 'Login successful');
            } else {
                return redirect()->back()->withErrors(['role' => 'Unauthorized Access Denied!']);
            }
        } catch (\Exception $e) {
            $this->logService->logError($e);
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'USER',
            ]);

            auth()->login($user);

            return redirect()->route('user.home')->with('success', 'Signup successful');

        } catch (\Exception $e) {
            $this->logService->logError($e);
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            $this->logService->logUserAction(
                auth()->user()->id,
                'LOGOUT',
                'User logged out',
                request()->ip(),
                request()->userAgent()
            );
            auth()->logout();
            session()->flush();
            return redirect()->route('login');
        } catch (\Exception $e) {
            $this->logService->logError($e);
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while logging out: ' . $e->getMessage()]);
        }
    }
}
