@extends('layout.app')

@section('title', 'Réinitialiser le mot de passe - PRIMAACADEMIE')

@section('content')

    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 p-md-5 shadow-sm" style="max-width: 482px; width: 100%;">
            <p class="mb-4 fw-semibold">Entrez votre adresse e-mail pour recevoir un lien de réinitialisation du mot de passe.</p>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('status') == 'We have emailed your password reset link.' ? 'Nous avons envoyé votre lien de réinitialisation de mot de passe !' : session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="exemple@email.com" required>
                </div>

                <button type="submit" class="btn btn-airbnb w-100 py-2">Envoyer le lien de réinitialisation du mot de passe</button>
            </form>
            <div class="text-center mt-4">
                <p class="text-muted mb-0">Retour à la page de connexion ?  
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#ff385c;">Connectez-vous ici</a>
                </p>
            </div>
        </div>
    </div>

@endsection
