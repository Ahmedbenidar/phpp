<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - {{ $professeur->nom }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-header {
            background: white;
            padding: 30px 0;
            border-bottom: 1px solid #ddd;
        }
        .profile-picture-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-picture {
            width: 168px;
            height: 168px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            object-fit: cover;
        }
        .profile-nav {
            background: white;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            padding: 0 20px;
        }
        .profile-nav .nav-link {
            padding: 15px 25px;
            color: #65676B;
            font-weight: 600;
        }
        .profile-nav .nav-link.active {
            color: #1877F2;
            border-bottom: 3px solid #1877F2;
        }
        .profile-content {
            background: #f0f2f5;
            min-height: calc(100vh - 350px);
            padding: 20px 0;
        }
        .info-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .info-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
        }
        .info-list {
            padding: 15px 20px;
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .info-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            color: #65676B;
        }
        .change-photo-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #f0f2f5;
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="profile-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="profile-picture-container position-relative d-inline-block">
                        <img src="{{ $professeur->photo ? asset('storage/photos/'.$professeur->photo) : asset('images/default-avatar.png') }}" 
                             class="profile-picture" alt="Photo de profil">
                        <form action="{{ route('professeur.update.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                            @csrf
                            @method('POST')
                            <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*">
                            <label for="photoInput" class="change-photo-btn" title="Changer la photo">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm1-13h-2v4H7v2h4v4h2v-4h4v-2h-4V7z"/>
                                </svg>
                            </label>
                        </form>
                    </div>
                    <h1 class="mb-1">{{ $professeur->nom }} {{ $professeur->prenom }}</h1>
                    <p class="text-muted">{{ $professeur->specialite }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-nav">
        <div class="container">
            <ul class="nav justify-content-center">
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
        </div>
    </div>

    <div class="profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-card-header">
                            Informations
                        </div>
                        <div class="info-list">
                            <div class="info-item">
                                <svg class="info-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm1-13h-2v6h6v-2h-4v-4z"/>
                                </svg>
                                <span>membre depuis {{ \Carbon\Carbon::parse($professeur->date_embauche)->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-item">
                                <svg class="info-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                                </svg>
                                <span>{{ $professeur->email }}</span>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="info-card">
                        <div class="info-card-header">
                            Publications récentes
                        </div>
                        <div class="info-list">
                            <p class="text-muted text-center py-4">Aucune publication pour le moment</p>
                        </div>
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