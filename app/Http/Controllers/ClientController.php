<?php
namespace App\Http\Controllers;


use App\Models\City;
use App\Models\Filiere;
use App\Models\Client;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Smalot\PdfParser\Parser as PdfParser;
use Spatie\PdfToImage\Pdf;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['ciity', 'filiere'])
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('client.index', compact('clients'));
    }

    public function create()
    {
        $cities = City::all();
        $filieres = Filiere::all();
        return view('client.create', compact('cities', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:6',
            'numero_telephone' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'numero_telephone' => $request->numero_telephone,
            'city_id' => $request->city_id,
            'filiere_id' => $request->filiere_id,
            
        ]);

        return redirect()->back()->with('success', 'Client ajouté avec succès!');
    }

    public function showLoginForm()
    {
        return view('client.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('client')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Redirection vers la page home après une connexion réussie
            return redirect()->route('client.home');
        }

        return back()->with('error', 'Les identifiants fournis ne correspondent pas à nos enregistrements.');
    }

    
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $cities = City::all();
        $filieres = Filiere::all();
        return view('client.edit', compact('client', 'cities', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:clients,email,' . $id,
            'numero_telephone' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $client->update($data);

        return redirect()->route('client.index')
            ->with('success', 'Client mis à jour avec succès!');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('client.index')
            ->with('success', 'Client supprimé avec succès!');
    }









    
    public function home()
    {
        $publications = Publication::with('client')
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('client.home', compact('publications'));
    }

    public function profile()
    {
        $client = auth()->user();
        $publications = Publication::where('client_id', auth()->id())->orderBy('created_at', 'desc')->get();
        
        return view('client.profile', compact('client', 'publications'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $client = Auth::guard('client')->user();

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($client->photo) {
                Storage::disk('public')->delete('photos/' . $client->photo);
            }

            // Sauvegarder la nouvelle photo
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('photos', $photoName, 'public');

            // Mettre à jour la base de données
            $client->photo = $photoName;
            $client->save();

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
            
            $client = Client::where(function($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where(function($q) use ($term) {
                        $q->where('nom', 'LIKE', "%{$term}%")
                          ->orWhere('prenom', 'LIKE', "%{$term}%");
                    });
                }
            })->first();

            if (!$client) {
                return redirect()->back()->with('error', 'Aucun client trouvé avec ce nom.');
            }

            return view('client.searchprofile', compact('client'));
        }

        return view('client.searchprofile');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }





    public function show($id)
    {
        $client = Client::with('publications')->findOrFail($id);
        return view('client.searchprofile', compact('client'));
    }

    public function updateReleveBancaire(Request $request)
    {
        $request->validate([
            'releve_bancaire' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        $client = auth()->user();

        if ($request->hasFile('releve_bancaire')) {
            $file = $request->file('releve_bancaire');
            $filename = 'releve_' . $client->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('releves_bancaires', $filename, 'public');
            $client->releve_bancaire = $filename;
            $client->save();
        }

        return redirect()->back()->with('success', 'Relevé bancaire mis à jour avec succès.');
    }

    public function showReleveBancaire($id)
    {
        $client = Client::findOrFail($id);
        $filePath = storage_path('app/public/releves_bancaires/' . $client->releve_bancaire);
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $text = '';

        if ($extension === 'pdf') {
            // 1. Essayer d'extraire le texte
            $parser = new PdfParser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            // 2. Si le texte est trop court, c'est sûrement un PDF scanné → OCR
            if (strlen(trim($text)) < 50) {
                // Convertir chaque page en image et faire l'OCR
                $pdfToImage = new Pdf($filePath);
                $pages = $pdfToImage->getNumberOfPages();
                $text = '';
                for ($i = 1; $i <= $pages; $i++) {
                    $pdfToImage->setPage($i)->saveImage(storage_path("app/temp_page_$i.jpg"));
                    putenv('TESSDATA_PREFIX=C:\Program Files\Tesseract-OCR\tessdata');
                    $text .= (new TesseractOCR(storage_path("app/temp_page_$i.jpg")))->lang('fra', 'eng')->run() . "\n";
                    @unlink(storage_path("app/temp_page_$i.jpg")); // Nettoyage
                }
            }
        } else {
            // Image directe → OCR
            putenv('TESSDATA_PREFIX=C:\Program Files\Tesseract-OCR\tessdata');
            $text = (new TesseractOCR($filePath))->lang('fra', 'eng')->run();
        }

        $lines = explode("\n", $text);
        $transactions = $this->parseReleveText($text);

        return view('client.releve_bancaire', [
            'client' => $client,
            'transactions' => $transactions,
            'raw_lines' => $lines, // Pour debug, à retirer en prod
        ]);
    }

    private function parseReleveText($text)
    {
        $lines = explode("\n", $text);
        $transactions = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Cherche une date au début de la ligne (formats français et US)
            if (preg_match('/^(\d{2}\/\d{2}\/\d{2,4})\s+(.+)$/', $line, $matches)) {
                $date = $matches[1];
                $rest = $matches[2];

                // Découpe le reste de la ligne sur 2 espaces ou plus, ou tabulation
                $parts = preg_split('/\s{2,}|\t+/', $rest);

                // On essaye d'assigner les colonnes
                $description = '';
                $credit = '';
                $debit = '';
                $solde = '';

                // On cherche les montants dans la ligne
                foreach ($parts as $p) {
                    // Montant (accepte 1 000,00 ou 1000.00)
                    if (preg_match('/^-?\d{1,3}(?:[ .]\d{3})*(?:[,.]\d{2})$/', $p)) {
                        if ($debit === '') {
                            $debit = $p;
                        } elseif ($credit === '') {
                            $credit = $p;
                        } elseif ($solde === '') {
                            $solde = $p;
                        }
                    } else {
                        $description .= ($description ? ' ' : '') . $p;
                    }
                }

                $transactions[] = [
                    'date' => $date,
                    'description' => $description,
                    'debit' => $debit,
                    'credit' => $credit,
                    'solde' => $solde,
                ];
            }
        }

        return $transactions;
    }

}

