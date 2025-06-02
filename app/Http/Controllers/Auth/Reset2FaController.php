<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\ValidationException;

class Reset2FaController extends Controller
{
    public function showResetForm()
    {
        return view('auth.reset2fa');
    }

    public function generateBackupCodes(Request $request)
    {
        try {
            $user = \App\Models\User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['success' => false, 'error' => 'User not found']);
            }

            $role = $user->role;

            if ($role->name !== 'clinic_admin' || !$user->is_2fa_enabled) {
                return response()->json(['success' => false, 'error' => 'Only clinic admins with 2FA enabled can generate backup codes']);
            }

            $backupCodes = [];
            for ($i = 0; $i < 10; $i++) {
                $backupCodes[] = bin2hex(random_bytes(4));
            }

            $backupCodesString = implode("\n", $backupCodes);
            $backupCodesBase64 = base64_encode($backupCodesString);

            \DB::transaction(function () use ($user, $backupCodesBase64) {
                $user->update([
                    'backup_codes' => $backupCodesBase64,
                ]);
            });

            // Send backup codes to user's email
            \Mail::to($user->email)->send(new \App\Mail\BackupCodesMail($backupCodes));

            return response()->json(['success' => true, 'message' => 'Backup codes generated and sent to your email']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'An error occurred while generating backup codes: ' . $e->getMessage()]);
        }
    }


    public function verifyBackupCodeAndReset2FA(Request $request)
    {
        try {
            $request->validate([
                'backup_code' => 'required|string',
            ]);

            $email = session('Resetemail');
            $data= User::where('email',$email)->first();
            $role=Role::where('id',$data->role_id)->first();


            if ($role->name !== 'clinic_admin' || !$data->is_2fa_enabled) {
                return redirect()->back()->withErrors(['error' => 'Invalid 2FA verification request']);
            }

            $backupCodes = explode("\n", base64_decode($user->backup_codes));

            if (in_array($request->backup_code, $backupCodes)) {
                // Remove the used backup code
                $backupCodes = array_diff($backupCodes, [$request->backup_code]);
                $user->update([
                    'backup_codes' => null,
                    'google2fa_secret' => null,
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;
                return redirect()->route('login')->with('success', '2FA has been reset');
            }

            return redirect()->back()->withErrors(['error' => 'Invalid backup code']);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred during backup code verification and 2FA reset']);
        }
    }



}
