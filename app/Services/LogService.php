<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class LogService
{
    /**
     * Log an error to the ErrorLog table.
     *
     * @param \Exception $exception
     * @return void
     */
    public function logError(\Exception $exception): void
    {
        DB::table('ErrorLog')->insert([
            'error_code' => null,
            'error_message' => $exception->getMessage(),
            'error_level' => 'ERROR',
            'error_context' => json_encode([
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ]),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'user_id' => auth()->user()->id ?? null,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }

    /**
     * Log a user action to the UserLog table.
     *
     * @param int $userId
     * @param string $actionType
     * @param string $description
     * @param string $ip
     * @param string $userAgent
     * @return void
     */
    public function logUserAction(int $userId, string $actionType, string $description, string $ip, string $userAgent): void
    {
        DB::table('UserLog')->insert([
            'user_id' => $userId,
            'action_type' => $actionType,
            'description' => $description,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'created_at' => now(),
        ]);
    }
}
