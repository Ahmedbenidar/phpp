<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: black;
        }
        .form-container {
            background-color: black;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        .form-header h2 {
            color: white;
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }
        .form-label {
            font-weight: 500;
            color: white;
            margin-bottom: 0.5rem;
        }
        .btn-submit {
            background-color: green;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: darkgreen;
            transform: translateY(-1px);
        }
        .input-group-text {
            background-color: green;
            border: 1px solid #dee2e6;
            color: white;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .invalid-feedback {
            font-size: 0.85rem;
        }
        .forgot-password {
            color: #4a90e2;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .forgot-password:hover {
            color: #357abd;
        }
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: white;
        }
        .register-link a {
            color: green;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link a:hover {
            color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <div class="form-header">
                        <h2><i class="fas fa-user-circle"></i> Connexion client</h2>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('client.login') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-white" for="remember">Se souvenir de moi</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </button>
                        </div>

                        <div class="register-link">
                            Pas encore de compte ? 
                            <a href="{{ route('client.create') }}">S'inscrire</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 