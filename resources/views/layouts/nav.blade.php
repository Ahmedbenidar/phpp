<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Gestion des Professeurs</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('professeur.index') ? 'active' : '' }}" 
                       href="{{ route('professeur.index') }}">
                        <i class="fas fa-list me-2"></i>Liste
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('professeur.create') ? 'active' : '' }}" 
                       href="{{ route('professeur.create') }}">
                        <i class="fas fa-plus me-2"></i>Ajouter
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('professeur.login') ? 'active' : '' }}" 
                       href="{{ route('professeur.login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Connexion
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav> 