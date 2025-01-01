<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Filiere;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('professeur')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function show($id)
    {
        $professeur = Professeur::findOrFail($id);
        return view('professeur.show', compact('professeur'));
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
}
