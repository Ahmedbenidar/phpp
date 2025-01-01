<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: black;
            color: white;
        }
        .form-container {
            background-color: #1a1a1a;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .form-control, .form-select {
            background-color: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: white;
        }
        .form-control:focus, .form-select:focus {
            background-color: #2a2a2a;
            color: white;
            border-color: green;
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 0, 0.25);
        }
    </style>
</head>
<body>
    @include('layouts.nav')

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4">Modifier le Professeur</h2>

            <form action="{{ route('professeur.update', $professeur->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $professeur->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                               id="prenom" name="prenom" value="{{ old('prenom', $professeur->prenom) }}" required>
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $professeur->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                    <input type="tel" class="form-control @error('numero_telephone') is-invalid @enderror" 
                           id="numero_telephone" name="numero_telephone" 
                           value="{{ old('numero_telephone', $professeur->numero_telephone) }}">
                    @error('numero_telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="city_id" class="form-label">Ville</label>
                        <select class="form-select @error('city_id') is-invalid @enderror" 
                                id="city_id" name="city_id" required>
                            <option value="">Sélectionnez une ville</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" 
                                    {{ old('city_id', $professeur->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="filiere_id" class="form-label">Filière</label>
                        <select class="form-select @error('filiere_id') is-invalid @enderror" 
                                id="filiere_id" name="filiere_id" required>
                            <option value="">Sélectionnez une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" 
                                    {{ old('filiere_id', $professeur->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('filiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('professeur.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 