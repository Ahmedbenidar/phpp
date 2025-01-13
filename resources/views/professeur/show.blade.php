@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Profil de {{ $professeur->nom }} {{ $professeur->prenom }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($professeur->photo)
                        <img src="{{ asset($professeur->photo) }}" class="img-fluid rounded" alt="Photo de profil">
                    @endif
                </div>
                <div class="col-md-8">
                    <h4>Informations personnelles</h4>
                    <p><strong>Email:</strong> {{ $professeur->email }}</p>
                    <p><strong>Téléphone:</strong> {{ $professeur->telephone }}</p>
                    <!-- Ajoutez d'autres informations selon votre structure de base de données -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 