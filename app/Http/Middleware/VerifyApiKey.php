<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $apiKey = $request->header('x-api-key');

            if (!$apiKey) {
                return response()->json(['error' => 'API key is required'], 401);
            }

            $key = ApiKey::where('key', $apiKey)->first();

            if (!$key) {
                return response()->json(['error' => 'Invalid API key'], 401);
            }

            // Attach the user to the request
            $request->merge(['api_user' => $key->user]);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
