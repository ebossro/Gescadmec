@extends('layout.app')

@section('title', 'Connexion - PRIMAACADEMIE')

@section('content')

    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 p-md-5 shadow-sm" style="max-width: 420px; width: 100%;">
            <h1 class="text-center mb-4 fw-semibold">Connectez-vous !</h1>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class='bx bx-error-circle me-2'></i>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('status') == 'Your password has been reset.' ? 'Votre mot de passe a été réinitialisé avec succès !' : session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="exemple@email.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-airbnb w-100 py-2">Se connecter</button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted mb-0">Mot de passe oublié ?  
                    <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold" style="color:#ff385c;">Réinitialisez votre mot de passe</a>
                </p>
            </div>
        </div>
    </div>

@endsection
