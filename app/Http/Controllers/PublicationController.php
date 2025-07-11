<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicationController extends Controller
{
    public function store(Request $request)
    {
        // Validate content
        $request->validate([
            'message' => 'required|min:3'
        ]);

        // Get current professor
        $client = auth()->user();
        
        // Create publication with professor relationship
        $publication = Publication::create([
            'contenu' => $request->message,
            'client_id' => $client->id
        ]);

        // Log for debugging
        Log::info('Publication created', [
            'publication_id' => $publication->id,
            'client_id' => $client->id,
            'client_photo' => $client->photo
        ]);

        return redirect()->back()->with('success', 'Publication créée avec succès!');
    }

    public function index()
    {
        $publications = Publication::with('client') ->orderBy('created_at', 'desc')->get();
        
        return view('client.home', compact('publications'));
    }
}