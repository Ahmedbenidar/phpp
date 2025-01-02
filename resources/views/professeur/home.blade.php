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
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                    </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Mon Compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('professeur.profile') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-4">
        <h1>Bienvenue dans votre espace professeur</h1>
        
        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Section de publication -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="publicationForm" action="{{ route('professeur.publications.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" name="contenu" id="contenu" rows="3" placeholder="Que voulez-vous partager ?"></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des publications -->
        <div class="row">
            <div class="col-12" id="publications-container">
                @foreach($publications as $publication)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . $publication->professeur->avatar) }}" class="rounded-circle me-2" width="40" height="40" alt="Avatar">
                            <div>
                                <h6 class="mb-0">{{ $publication->professeur->nom }} {{ $publication->professeur->prenom }}</h6>
                                <small class="text-muted">{{ $publication->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="card-text">{{ $publication->contenu }}</p>
                        @if($publication->image)
                            <img src="{{ asset('storage/' . $publication->image) }}" class="img-fluid rounded mb-3" alt="Image de publication">
                        @endif
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-link text-decoration-none">J'aime</button>
                            <button class="btn btn-link text-decoration-none">Commenter</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script pour la gestion des publications -->
    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#publicationForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            let submitBtn = $(this).find('button[type="submit"]');
            
            // Désactiver le bouton pendant l'envoi
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Créer la nouvelle publication
                    let newPublication = `
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('storage/') }}/${response.professeur.avatar}" class="rounded-circle me-2" width="40" height="40" alt="Avatar">
                                    <div>
                                        <h6 class="mb-0">${response.professeur.nom} ${response.professeur.prenom}</h6>
                                        <small class="text-muted">À l'instant</small>
                                    </div>
                                </div>
                                <p class="card-text">${response.contenu}</p>
                                ${response.image ? `<img src="{{ asset('storage/') }}/${response.image}" class="img-fluid rounded mb-3" alt="Image de publication">` : ''}
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-link text-decoration-none">J'aime</button>
                                    <button class="btn btn-link text-decoration-none">Commenter</button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Ajouter la publication en haut de la liste
                    $('#publications-container').prepend(newPublication);
                    
                    // Réinitialiser le formulaire
                    $('#publicationForm')[0].reset();
                    
                    // Afficher un message de succès
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: 'Votre publication a été créée avec succès!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur!',
                        text: 'Une erreur est survenue lors de la publication.'
                    });
                },
                complete: function() {
                    // Réactiver le bouton
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>