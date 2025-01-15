<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Professeur</title>
    <!-- jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajout de SweetAlert2 pour de jolies alertes -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: #2d3748;
            line-height: 1.6;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        h1 {
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #1a472a;
            border-color: #1a472a;
        }

        .btn-primary:hover {
            background: #133620;
            border-color: #133620;
        }

        .publication-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 20px;
        }
        .publication-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .prof-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .publication-header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        .publication-content {
            padding: 20px;
            font-size: 1rem;
            line-height: 1.6;
        }
        .publication-footer {
            padding: 12px 20px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            border-radius: 0 0 12px 12px;
        }
        .prof-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar {
            background: linear-gradient(to right, #1a472a, #000000) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }

        .nav-link:hover {
            color: #90EE90 !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Espace Professeur</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <form class="d-flex" action="{{ route('professeur.searchprofile') }}" method="GET">
                            <input class="form-control me-2" type="search" name="search" placeholder="Rechercher..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Rechercher</button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Mon Compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('professeur.profile') }}">Profil</a></li>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Ajoutez ceci juste après la navbar -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Contenu principal -->
    <div class="container mt-4">
        <h1>Bienvenue dans votre espace professeur</h1>
        
        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de publication -->
        <div class="card mt-4">
            <div class="card-body">
                <form action="{{ route('professeur.publier') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">Votre message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Quoi de neuf ?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Publier</button>
                </form>
            </div>
        </div>

        <!-- Publications List -->
        <div class="container mt-4">
            @foreach($publications as $publication)
                <div class="card publication-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $publication->professeur->photo 
                                ? asset('storage/photos/' . $publication->professeur->photo) 
                                : asset('images/default-avatar.png') }}"
                                 class="profile-img me-3"
                                 alt="Photo de {{ $publication->professeur->nom }}"
                                 onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                            <div>
                                <h6 class="mb-0">{{ $publication->professeur->nom }}</h6>
                                <small class="text-muted">{{ $publication->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <p class="card-text">{{ $publication->contenu }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>