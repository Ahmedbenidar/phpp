<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - {{ $client->nom }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navbar-color: linear-gradient(135deg, #1a472a, #000000);
            --primary-color: #2c3e50;
            --secondary-color: #7f8c8d;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-dark: #333333;
            --text-light: #777777;
            --border-color: #e0e0e0;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Navbar - Couleur conservée comme dans votre code original */
        .navbar {
            background: var(--navbar-color) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Section Profil */
        .profile-header {
            background: var(--card-bg);
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-avatar-container {
            position: relative;
            width: 160px;
            margin: 0 auto 1.5rem;
        }

        .profile-avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--card-bg);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .avatar-edit {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .avatar-edit:hover {
            transform: scale(1.1);
            background: #1a252f;
        }

        .profile-name {
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .profile-title {
            color: var(--text-light);
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        /* Navigation secondaire */
        .profile-nav {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
        }

        .profile-nav .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            padding: 1rem 2rem;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .profile-nav .nav-link.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .profile-nav .nav-link:hover {
            color: var(--primary-color);
        }

        /* Cartes */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            background: var(--card-bg);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            color: var(--primary-color);
        }

        /* Boutons */
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
        }

        /* Liste d'informations */
        .info-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            color: var(--primary-color);
            margin-right: 1rem;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Publications */
        .publication {
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .publication:last-child {
            border-bottom: none;
        }

        .publication-date {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        /* Section upload */
        .upload-section {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
        }

        .form-control {
            border: 1px solid var(--border-color);
            padding: 0.7rem 1rem;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.1);
        }

        /* Alertes */
        .alert {
            border-radius: 6px;
            border: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.home') }}">Mon Espace</a>
            
            <div class="collapse navbar-collapse">
                <form class="d-flex ms-auto me-3" action="{{ route('client.searchprofile') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Rechercher..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> Mon Compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="profile-header text-center">
            <div class="profile-avatar-container">
                <img src="{{ $client->photo ? asset('storage/photos/'.$client->photo) : asset('images/default-avatar.png') }}" 
                     class="profile-avatar" alt="Photo de profil">
                <form action="{{ route('client.update.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                    @csrf
                    <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*">
                    <label for="photoInput" class="avatar-edit" title="Changer la photo">
                        <i class="fas fa-camera"></i>
                    </label>
                </form>
            </div>
            <h1 class="profile-name">{{ $client->nom }} {{ $client->prenom }}</h1>
            <p class="profile-title">{{ $client->specialite }}</p>
        </div>

        <div class="profile-nav">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-user me-2"></i>À propos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-newspaper me-2"></i>Publications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-images me-2"></i>Photos
                    </a>
                </li>
            </ul>
        </div>

        <div class="row mt-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Informations personnelles
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <i class="fas fa-calendar-alt info-icon"></i>
                            <span>Membre depuis {{ \Carbon\Carbon::parse($client->date_embauche)->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope info-icon"></i>
                            <span>{{ $client->email }}</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-invoice me-2"></i>Relevé bancaire
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.update.releve_bancaire') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="releve_bancaire" class="form-label">Importer un fichier</label>
                                <input class="form-control" type="file" name="releve_bancaire" id="releve_bancaire" accept="image/*,application/pdf" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-upload me-2"></i>Téléverser
                            </button>
                        </form>
                        <a href="{{ route('client.releve_bancaire', ['id' => Auth::user()->id]) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-eye me-2"></i>Consulter mon relevé
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-newspaper me-2"></i>Mes dernières publications
                    </div>
                    <div class="card-body">
                        @forelse($client->publications as $publication)
                            <div class="publication">
                                <p class="publication-date">
                                    <i class="far fa-clock me-1"></i>
                                    Publié le {{ $publication->created_at->format('d/m/Y à H:i') }}
                                </p>
                                <p class="mb-3">{{ $publication->contenu }}</p>
                                
                                @if($publication->fichier)
                                    <a href="{{ asset('storage/publications/' . $publication->fichier) }}" 
                                       class="btn btn-sm btn-primary" 
                                       target="_blank">
                                        <i class="fas fa-file-download me-1"></i>Télécharger
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center py-3">Aucune publication pour le moment</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('photoInput').addEventListener('change', function() {
            document.getElementById('photoForm').submit();
        });
    </script>
</body>
</html>