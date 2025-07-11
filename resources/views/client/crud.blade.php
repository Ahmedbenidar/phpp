<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Professeurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: black;
            color: white;
        }
        .table {
            color: white;
        }
        .table-dark {
            --bs-table-bg: #1a1a1a;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .action-column {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Liste des Professeurs</h2>
            <a href="{{ route('professeur.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Nouveau Professeur
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Ville</th>
                        <th>Filière</th>
                        <th class="action-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($professeurs as $professeur)
                        <tr>
                            <td>{{ $professeur->id }}</td>
                            <td>{{ $professeur->nom }}</td>
                            <td>{{ $professeur->prenom }}</td>
                            <td>{{ $professeur->email }}</td>
                            <td>{{ $professeur->numero_telephone ?? 'N/A' }}</td>
                            <td>{{ $professeur->ciity->name }}</td>
                            <td>{{ $professeur->filiere->name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('professeur.show', $professeur) }}" 
                                       class="btn btn-info btn-action" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('professeur.edit', $professeur) }}" 
                                       class="btn btn-warning btn-action" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('professeur.destroy', $professeur) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur?')"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $professeurs->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 