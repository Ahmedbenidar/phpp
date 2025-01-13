<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function store(Request $request)
    {
        // Valider le contenu
        $request->validate([
            'message' => 'required|min:3'
        ]);

        // Créer la publication
        Publication::create([
            'contenu' => $request->message,
            'professeur_id' => auth()->id()
        ]);

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Publication créée avec succès!');
    }
}
