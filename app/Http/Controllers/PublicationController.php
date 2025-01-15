<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Professeur;
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
        $professeur = auth()->user();
        
        // Create publication with professor relationship
        $publication = Publication::create([
            'contenu' => $request->message,
            'professeur_id' => $professeur->id
        ]);

        // Log for debugging
        Log::info('Publication created', [
            'publication_id' => $publication->id,
            'professeur_id' => $professeur->id,
            'professeur_photo' => $professeur->photo
        ]);

        return redirect()->back()->with('success', 'Publication créée avec succès!');
    }

    public function index()
    {
        $publications = Publication::with('professeur')
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        
        return view('professeur.home', compact('publications'));
    }
}