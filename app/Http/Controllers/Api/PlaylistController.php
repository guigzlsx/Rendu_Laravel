<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlaylistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->get('api_user');
            
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            $playlists = $user->playlists()
                ->with('tracks')
                ->get();

            return response()->json($playlists);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
