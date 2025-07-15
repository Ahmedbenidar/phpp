<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Client </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: black;
            color: white;
        }
        .card {
            background-color: #1a1a1a;
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            color: white;
        }
        .info-label {
            font-weight: bold;
            color: orange;
            min-width: 120px;
            display: inline-block;
        }
        .btn-success {
            background-color: green;
            border: none;
        }
        .btn-success:hover {
            background-color: darkgreen;
        }
        .info-value {
            color: #ffffff;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #333;
        }
        .info-row:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    @include('layouts.nav')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Détails du Client</h2>
            <a href="{{ route('client.index') }}" class="btn btn-success">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Nom:</span>
                    <span class="info-value">{{ $client->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Prénom:</span>
                    <span class="info-value">{{ $client->prenom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $client->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone:</span>
                    <span class="info-value">{{ $client->numero_telephone ?? 'Non renseigné' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ville:</span>
                    <span class="info-value">{{ $client->ciity->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Filière:</span>
                    <span class="info-value">{{ $client->filiere->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Inscrit le:</span>
                    <span class="info-value">{{ $client->created_at->format('d/m/Y') }}</span>
                </div>

                <div class="mt-4">
                    <a href="{{ route('client.edit', $client->id) }}" class="btn btn-success me-2">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    <form action="{{ route('client.destroy', $client->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                            <i class="fas fa-trash me-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 