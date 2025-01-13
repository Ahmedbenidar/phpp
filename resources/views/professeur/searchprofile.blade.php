<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin: 40px 0;
        }
        .profile-avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .profile-name {
            font-size: 32px;
            margin-top: 20px;
            color: #333;
        }
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 30px;
            justify-content: center;
        }
        .nav-tabs .nav-link {
            color: #666;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
        }
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            background: none;
        }
        .info-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .info-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #666;
        }
        .info-item i {
            margin-right: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        @if(isset($professeur))
            <div class="profile-header">
                <div class="profile-avatar-container">
                    <img src="{{ asset('storage/photos/' . $professeur->photo) }}" alt="Profile" class="profile-avatar">
                    <div class="add-photo-button">
                        <span>+</span>
                    </div>
                </div>
                <h1 class="profile-name">{{ $professeur->nom }} {{ $professeur->prenom }}</h1>
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
                            <span>membre depuis {{ $professeur->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <i class="far fa-envelope"></i>
                            <span>{{ $professeur->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="info-section">
                        <h2 class="info-title">Publications</h2>
                        @if($professeur->publications && $professeur->publications->count() > 0)
                            @foreach($professeur->publications as $publication)
                                <div class="publication-item mb-4">
                                    <h3 class="publication-title">{{ $publication->titre }}</h3>
                                    <p class="publication-date text-muted">
                                        <small>Publié le {{ $publication->created_at->format('d/m/Y') }}</small>
                                    </p>
                                    <p class="publication-content">{{ $publication->contenu }}</p>
                                    @if($publication->fichier)
                                        <a href="{{ asset('storage/publications/' . $publication->fichier) }}" 
                                           class="btn btn-sm btn-primary" 
                                           target="_blank">
                                            Voir le document
                                        </a>
                                    @endif
                                    <hr>
                                </div>
                            @endforeach
                        @else
                            <p>Aucune publication pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Aucun professeur trouvé.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>
</html>
