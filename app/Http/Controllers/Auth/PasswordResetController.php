<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Log;
use App\Services\LogService;


class PasswordResetController extends Controller
{
    protected $logService;
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }
    public function showResetForm()
    {
        $email = session('email');
        return view('auth.passwords.reset',compact('email'));
    }

    public function sendre(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['The provided email is not registered.'],
                ]);
            }

            $otp = rand(100000, 999999);
            $expiry = now()->addMinutes(10);

            \App\Models\Otp::create([
                'email' => $request->email,
                'otp' => $otp,
                'expires_at' => $expiry,
            ]);

            $mailSent = \Mail::to($request->email)->send(new SendOtpMail($otp));
            $email = $request->email;
            session(['Resetemail' => $email]);

            if ($mailSent) {
                return redirect()->route('password.reset')->with(compact('otp', 'email'))->with('success', 'OTP has been sent to your email.');
            } else {
                return back()->withErrors([
                    'email' => 'An error occurred while attempting to send the OTP.',
                ]);
            }
        } catch (\Exception $e) {
            $this->logService->logError($e);
            Log::error($e->getMessage());
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|string|min:8',
        ]);

        try {

            $email = session('Resetemail');

            if (!$email) {
                throw ValidationException::withMessages([
                    'email' => ['No email found in session. Please try again.'],
                ]);
            }

            $otpRecord = \App\Models\Otp::where('email', $email)
                ->where('otp', $request->otp)
                ->where('expires_at', '>', now())
                ->first();

            if (!$otpRecord) {
                throw ValidationException::withMessages([
                    'otp' => ['The provided OTP is invalid or has expired.'],
                ]);
            }

            $email = $otpRecord->email;

            $user = User::where('email', $email)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            $otpRecord->update(['used' => true]);



            return redirect()->route('login')->with('success', 'Password has been successfully reset.');
        } catch (\Exception $e) {
            $this->logService->logError($e);
            Log::error($e->getMessage());
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}


