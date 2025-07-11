<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Gestion des Clients</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.index') ? 'active' : '' }}" 
                       href="{{ route('client.index') }}">
                        <i class="fas fa-list me-2"></i>Liste
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.create') ? 'active' : '' }}" 
                       href="{{ route('client.create') }}">
                        <i class="fas fa-plus me-2"></i>Ajouter
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.login') ? 'active' : '' }}" 
                       href="{{ route('client.login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Connexion
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav> 