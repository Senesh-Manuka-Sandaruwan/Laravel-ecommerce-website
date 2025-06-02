<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\LogService;




class AuthController extends Controller
{
   protected $logService;
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = DB::table('users')
                ->where('email', $request->email)
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'The provided credentials are incorrect'
                ], 401);
            }

            // // Check user role
            // if ($user->role !== 'USER') {
            //     return response()->json([
            //         'message' => 'Unauthorized'
            //     ], 403);
            // }

            $token = \Illuminate\Support\Str::random(60);
            $hashedToken = hash('sha256', $token);

            DB::table('personal_access_tokens')->insert([
                'tokenable_type' => 'auth_token',
                'tokenable_id' => $user->id,
                'name' => 'auth_token',
                'token' => $hashedToken,
                'abilities' => json_encode(['*']),
                'last_used_at' => now(),
                'expires_at' => now()->addDays(1),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                "token" => $token,
                "role" => $user->role, // Include the user's role in the response
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $cleanToken = trim($token, '"');
            $hashedToken = hash('sha256', $cleanToken);

            if ($hashedToken) {
                $deleted = DB::table('personal_access_tokens')
                    ->where('token', $hashedToken)
                    ->delete();

                if ($deleted) {
                    return response()->json(['message' => 'Successfully logged out'], 200);
                } else {
                    return response()->json(['message' => 'Token not found or already revoked'], 401);
                }
            }

            return response()->json(['message' => 'No active token found'], 401);
            
        } catch (\Exception $e) {
            $this->logService->logError($e);
            return response()->json([
                'message' => 'An error occurred during logout'
            ], 500);
        }
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Check if the email already exists
            $existingUser = DB::table('users')->where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json(['error' => 'Email already exists'], 409); // Return JSON response
            }

            // Insert into users table
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'USER', // Save the role
                'created_at' => now(),
                'updated_at' => now(),
            ]);

             $token = \Illuminate\Support\Str::random(60);
            $hashedToken = hash('sha256', $token);

            DB::table('personal_access_tokens')->insert([
                'tokenable_type' => 'auth_token',
                'tokenable_id' => $userId,
                'name' => 'auth_token',
                'token' => $hashedToken,
                'abilities' => json_encode(['*']),
                'last_used_at' => now(),
                'expires_at' => now()->addDays(1),
                'created_at' => now(),
                'updated_at' => now()
            ]);


            DB::commit();


            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'token' => $token,
                'role' => 'USER', // Include the role in the response
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->logService->logError($e);
            //print error in terminal
            \Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred during registration.'], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
            ]);

            $user = $request->attributes->get('user');
            
            $patientLogin = DB::table('PatientLogin')
                ->where('PatientID', $user->tokenable_id)
                ->first();

            if (!$patientLogin || !Hash::check($request->current_password, $patientLogin->Password)) {
                return response()->json([
                    'message' => 'Current password is incorrect'
                ], 401);
            }

            DB::table('PatientLogin')
                ->where('PatientID', $user->tokenable_id)
                ->update([
                    'Password' => Hash::make($request->new_password),
                    
                ]);

            return response()->json([
                'message' => 'Password changed successfully'
            ], 200);

        } catch (\Exception $e) {
            $this->logService->logError($e);
            return response()->json([
                'message' => 'An error occurred while changing password'
            ], 500);
        }
    }

    
}

