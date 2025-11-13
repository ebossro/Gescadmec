@extends('layout.app')

@section('title', 'Réinitialisation du mot de passe - PRIMAACADEMIE')

@section('content')

    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 p-md-5 shadow-sm" style="max-width: 420px; width: 100%;">
            <h3 class="text-center mb-4 fw-semibold">Réinitialisez votre mot de passe</h3>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#ff385c;">Retour à la page de connexion</a>
                </div>              
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="exemple@email.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-airbnb w-100 py-2">Réinitialiser le mot de passe</button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted mb-0">Retour à la page de connexion ?  
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#ff385c;">Connectez-vous ici</a>
                </p>
            </div>
        </div>
    </div>

@endsection
