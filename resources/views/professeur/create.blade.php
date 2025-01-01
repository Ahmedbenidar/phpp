<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: black;
        }
        .form-container {
            background-color: black;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        .form-header h2 {
            color: white;
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
            height: 50px;
            background-color: white;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }
        .form-label {
            font-weight: 500;
            color: white;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }
        .btn-submit, .btn-outline-light {
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
            margin: 0;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-submit {
            background-color: green;
            border: none;
            color: white;
        }
        .btn-submit:hover {
            background-color: darkgreen;
            transform: translateY(-1px);
        }
        .btn-outline-light {
            border: 2px solid green;
            color: green;
            background-color: transparent;
        }
        .btn-outline-light:hover {
            background-color: green;
            border-color: green;
            color: white;
            transform: translateY(-1px);
        }
        .input-group-text {
            background-color: green;
            border: 1px solid green;
            color: white;
            width: 45px;
            justify-content: center;
            height: 50px;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .invalid-feedback {
            display: block;
            color: #dc3545;
            margin-top: 0.25rem;
        }
        .row-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            align-items: flex-start;
        }
        .col-button {
            flex: 1;
            display: flex;
        }
        .col-button:last-child {
            margin-top: 10px;
        }
        .btn-submit i, .btn-outline-light i {
            margin-right: 8px;
            font-size: 16px;
            line-height: 1;
        }
        .row {
            margin: 0 -10px;
        }
        .col-md-6 {
            padding: 0 10px;
        }
        select.form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23000' viewBox='0 0 16 16'%3E%3Cpath d='M8 11.5l-5-5h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <div class="form-header">
                        <h2><i class="fas fa-user-plus"></i> Inscription Professeur</h2>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('professeur.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" name="nom" value="{{ old('nom') }}" required>
                                </div>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                </div>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control @error('numero_telephone') is-invalid @enderror" 
                                       id="numero_telephone" name="numero_telephone" value="{{ old('numero_telephone') }}">
                            </div>
                            @error('numero_telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="city_id" class="form-label">Ville</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    <select class="form-select @error('city_id') is-invalid @enderror" 
                                            id="city_id" name="city_id" required>
                                        <option value="">Sélectionnez une ville</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="filiere_id" class="form-label">Filière</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <select class="form-select @error('filiere_id') is-invalid @enderror" 
                                            id="filiere_id" name="filiere_id" required>
                                        <option value="">Sélectionnez une filière</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                                {{ $filiere->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('filiere_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row-buttons">
                            <div class="col-button">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-2"></i>S'inscrire
                                </button>
                            </div>
                            <div class="col-button">
                                <a href="{{ route('professeur.login') }}" class="btn btn-outline-light">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 