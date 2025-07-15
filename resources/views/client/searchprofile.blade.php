<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a472a;
            --primary-dark: #133620;
            --secondary-color: #2d3748;
            --background: #f8f9fa;
            --card-shadow: 0 2px 15px rgba(0,0,0,0.08);
            --navbar-height: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--secondary-color);
            line-height: 1.7;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        .profile-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .profile-avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-name {
            color: var(--primary-color);
            font-weight: 600;
            margin: 1rem 0;
            font-size: 2rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--secondary-color);
            font-weight: 500;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }

        .info-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }
    </style>
    <style>
        /* Navbar Specific Styles */
        .navbar {
            background: linear-gradient(135deg, #1a472a, #000000) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            height: 60px;
            padding: 0.5rem 1rem;
        }

        .navbar-brand, .nav-link {
            color:rgb(130, 123, 123) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color:rgb(111, 125, 111) !important;
            transform: translateY(-2px);
        }

        .navbar .container {
            height: 100%;
            display: flex;
            align-items: center;
        }

        .navbar-nav .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Espace Client</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <form class="d-flex" action="{{ route('client.searchprofile') }}" method="GET">
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
                            <li><a class="dropdown-item" href="{{ route('client.profile') }}">Profil</a></li>
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

    <div class="profile-container">
        @if(isset($client))
            <div class="profile-header">
                <div class="profile-avatar-container">
                    <img src="{{ asset('storage/photos/' . $client->photo) }}" alt="Profile" class="profile-avatar">
                    <div class="add-photo-button">
                        <span>+</span>
                    </div>
                </div>
                <h1 class="profile-name">{{ $client->nom }} {{ $client->prenom }}</h1>
            </div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Publications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Photos</a>
                </li>
            </ul>

            <div class="row">
                <div class="col-md-4">
                    <div class="info-section">
                        <h2 class="info-title">Informations</h2>
                        <div class="info-item">
                            <i class="far fa-clock"></i>
                            <span>membre depuis {{ $client->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <i class="far fa-envelope"></i>
                            <span>{{ $client->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="info-section">
                        <h2 class="info-title">Publications</h2>
                        @if($client->publications && $client->publications->count() > 0)
                            @foreach($client->publications as $publication)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p class="text-muted mb-1">
                                            <small>Publié le {{ $publication->created_at->format('d/m/Y à H:i') }}</small>
                                        </p>
                                        <p class="card-text">{{ $publication->contenu }}</p>
                                        
                                        @if($publication->fichier)
                                            <a href="{{ asset('storage/publications/' . $publication->fichier) }}" 
                                               class="btn btn-sm btn-primary" 
                                               target="_blank">
                                                <i class="fas fa-file-download"></i> Voir le document
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucune publication pour le moment.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Aucun client trouvé.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>
</html>