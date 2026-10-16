<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SystemAPIs;

class ApiTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $requiredApiType = null)
    {
        // Get the API type from the API-Type header
        $apiType = $request->header('API-Type');

        // If no API type provided, return unauthorized
        if (!$apiType) {
            return response()->json([
                'success' => false,
                'message' => 'API-Type header is required',
                'error_code' => 'MISSING_API_TYPE'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // If a specific API type is required for this route group, validate it
        if ($requiredApiType && $apiType !== $requiredApiType) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API type for this endpoint',
                'error_code' => 'INVALID_API_TYPE_FOR_ENDPOINT'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Get the token from the Authorization header
        $token = $request->bearerToken();

        // If no token provided, return unauthorized
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Authorization token is required',
                'error_code' => 'MISSING_TOKEN'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Validate the API type and token
        $validationResult = $this->validateApiTypeAndToken($apiType, $token);

        if (!$validationResult['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validationResult['message'],
                'error_code' => $validationResult['error_code']
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    /**
     * Validate the API type and token against database records
     *
     * @param string $apiType
     * @param string $token
     * @return array
     */
    private function validateApiTypeAndToken($apiType, $token)
    {
        // First, check if the API type exists in the database
        $apiRecord = SystemAPIs::where('api_type_key', $apiType)->first();

        if (!$apiRecord) {
            return [
                'valid' => false,
                'message' => 'Invalid API type',
                'error_code' => 'INVALID_API_TYPE'
            ];
        }

        // Check if the API is active (is_active = 1)
        if ($apiRecord->is_active != 1) {
            return [
                'valid' => false,
                'message' => 'API access has expired or is inactive',
                'error_code' => 'API_EXPIRED'
            ];
        }

        // Validate the token against the stored token
        if (!hash_equals($apiRecord->api_token, $token)) {
            return [
                'valid' => false,
                'message' => 'Invalid or unauthorized token',
                'error_code' => 'INVALID_TOKEN'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Validation successful',
            'error_code' => null
        ];
    }
}
