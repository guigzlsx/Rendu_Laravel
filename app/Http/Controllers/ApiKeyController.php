<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApiKeyController extends Controller
{
    public function index()
    {
        $apiKeys = auth()->user()->apiKeys()->latest()->get();
        
        return Inertia::render('ApiKeys/Index', [
            'apiKeys' => $apiKeys
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apiKey = auth()->user()->apiKeys()->create($validated);

        return redirect()->back()->with('success', 'API key created successfully.');
    }

    public function destroy(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== auth()->id()) {
            abort(403);
        }

        $apiKey->delete();

        return redirect()->back()->with('success', 'API key deleted successfully.');
    }

    public function preview(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== auth()->id()) {
            abort(403);
        }

        $playlists = $apiKey->user->playlists()
            ->with('tracks')
            ->get();

        return Inertia::render('ApiKeys/Preview', [
            'apiKey' => $apiKey,
            'playlists' => $playlists
        ]);
    }
}
