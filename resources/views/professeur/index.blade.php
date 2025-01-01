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
            margin-top: 20px;
        }
        .table-dark {
            --bs-table-bg: #1a1a1a;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            margin: 0 2px;
        }
        .action-column {
            width: 150px;
            text-align: center;
        }
        .table-container {
            background-color: #1a1a1a;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .page-title {
            color: white;
            margin-bottom: 30px;
        }
        .btn-add {
            background-color: green;
            border: none;
            padding: 10px 20px;
        }
        .btn-add:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    @include('layouts.nav')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="page-title">Liste des Professeurs</h2>
            <a href="{{ route('professeur.create') }}" class="btn btn-success btn-add">
                <i class="fas fa-plus me-2"></i>Nouveau Professeur
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
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
                        @forelse($professeurs as $professeur)
                            <tr>
                                <td>{{ $professeur->id }}</td>
                                <td>{{ $professeur->nom }}</td>
                                <td>{{ $professeur->prenom }}</td>
                                <td>{{ $professeur->email }}</td>
                                <td>{{ $professeur->numero_telephone ?? 'N/A' }}</td>
                                <td>{{ $professeur->ciity->name }}</td>
                                <td>{{ $professeur->filiere->name }}</td>
                                <td class="action-column">
                                    <a href="{{ route('professeur.show', $professeur->id) }}" class="btn btn-info btn-action">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('professeur.edit', $professeur->id) }}" class="btn btn-success btn-action">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('professeur.destroy', $professeur->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun professeur trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $professeurs->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 