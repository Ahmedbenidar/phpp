<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $publication = new Publication();
        $publication->contenu = $request->contenu;
        $publication->professeur_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('publications', 'public');
            $publication->image = $path;
        }

        $publication->save();

        if($request->ajax()) {
            return response()->json([
                'contenu' => $publication->contenu,
                'image' => $publication->image,
                'professeur' => [
                    'nom' => auth()->user()->nom,
                    'prenom' => auth()->user()->prenom,
                    'avatar' => auth()->user()->avatar
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Publication créée avec succès!');
    }
}