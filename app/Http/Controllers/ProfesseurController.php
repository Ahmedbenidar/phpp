<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Filiere;
use App\Models\Professeur;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfesseurController extends Controller
{
    public function index()
    {
        $professeurs = Professeur::with(['ciity', 'filiere'])
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('professeur.index', compact('professeurs'));
    }

    public function create()
    {
        $cities = City::all();
        $filieres = Filiere::all();
        return view('professeur.create', compact('cities', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:professeurs',
            'password' => 'required|min:6',
            'numero_telephone' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        Professeur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'numero_telephone' => $request->numero_telephone,
            'city_id' => $request->city_id,
            'filiere_id' => $request->filiere_id,
        ]);

        return redirect()->back()->with('success', 'Professeur ajouté avec succès!');
    }

    public function showLoginForm()
    {
        return view('professeur.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('professeur')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Redirection vers la page home après une connexion réussie
            return redirect()->route('professeur.home');
        }

        return back()->with('error', 'Les identifiants fournis ne correspondent pas à nos enregistrements.');
    }

    public function show($id)
    {
        $professeur = Professeur::with('publications')->findOrFail($id);
        return view('professeur.searchprofile', compact('professeur'));
    }

    public function edit($id)
    {
        $professeur = Professeur::findOrFail($id);
        $cities = City::all();
        $filieres = Filiere::all();
        return view('professeur.edit', compact('professeur', 'cities', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $professeur = Professeur::findOrFail($id);
        
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:professeurs,email,' . $id,
            'numero_telephone' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $professeur->update($data);

        return redirect()->route('professeur.index')
            ->with('success', 'Professeur mis à jour avec succès!');
    }

    public function destroy($id)
    {
        $professeur = Professeur::findOrFail($id);
        $professeur->delete();
        return redirect()->route('professeur.index')
            ->with('success', 'Professeur supprimé avec succès!');
    }

    public function home()
    {
        $publications = Publication::with('professeur')
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('professeur.home', compact('publications'));
    }

    public function profile()
    {
        $professeur = auth()->user();
        $publications = Publication::where('professeur_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        return view('professeur.profile', compact('professeur', 'publications'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $professeur = Auth::guard('professeur')->user();

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($professeur->photo) {
                Storage::disk('public')->delete('photos/' . $professeur->photo);
            }

            // Sauvegarder la nouvelle photo
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('photos', $photoName, 'public');

            // Mettre à jour la base de données
            $professeur->photo = $photoName;
            $professeur->save();

            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès');
        }

        return redirect()->back()->with('error', 'Erreur lors du téléchargement de la photo');
    }

    public function searchprofile(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            // Séparons la recherche en mots
            $searchTerms = explode(' ', $search);
            
            $professeur = Professeur::where(function($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where(function($q) use ($term) {
                        $q->where('nom', 'LIKE', "%{$term}%")
                          ->orWhere('prenom', 'LIKE', "%{$term}%");
                    });
                }
            })->first();

            if (!$professeur) {
                return redirect()->back()->with('error', 'Aucun professeur trouvé avec ce nom.');
            }

            return view('professeur.searchprofile', compact('professeur'));
        }

        return view('professeur.searchprofile');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
