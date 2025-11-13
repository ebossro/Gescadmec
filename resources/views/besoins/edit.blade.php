@extends('layout.app')

@section('title', 'Traiter le besoin')

@section('content')
<div class="d-flex">
    <div class="d-flex flex-column bg-white border-end" style="width: 260px; min-height: 100vh;">
    <!-- Logo -->
    <div class="p-4 border-bottom">
        <h3 class="mb-0" style="color: #ff385c; font-weight: bold;">GESCADMEC</h3>
    </div>

    <!-- Menu -->
    <nav class="flex-grow-1 p-3">
        <div class="mb-3">
            <x-sidebar-link route="admin.index" icon="bx bx-bar-chart-alt-2" label="Tableau de bord" />
        </div>

        <div class="mb-3">
            <x-sidebar-link route="etudiants.index" icon="bx bx-group" label="Étudiants" />
        </div>

        <div class="mb-3">
            <x-sidebar-link route="paiements.index" icon="bx bx-credit-card" label="Paiements" />
        </div>

        <div class="mb-3">
            <x-sidebar-link route="besoins.index" icon="bx bx-message-square-detail" label="Besoins" />
        </div>
    </nav>

    <!-- Déconnexion -->
    <div class="p-3 border-top">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class='bx bx-log-out me-2'></i>Déconnexion
            </button>
        </form>
    </div>
</div>


    <div class="flex-grow-1" style="background-color: #f8f9fa;">
        <div class="bg-white border-bottom px-4 py-3">
            <h4 class="mb-0">Traiter le besoin</h4>
            <p class="text-muted small mb-0">{{ $besoin->sujet }}</p>
        </div>

        <div class="p-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Informations du besoin -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Informations du besoin</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted small">Étudiant</p>
                                    <p class="mb-0"><strong>{{ $besoin->etudiant->nom_complet }}</strong></p>
                                    <p class="mb-0 small">{{ $besoin->etudiant->telephone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted small">Date de demande</p>
                                    <p class="mb-0">{{ $besoin->date_demande->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Catégorie</p>
                                <span class="badge bg-secondary">{{ ucfirst($besoin->categorie) }}</span>
                            </div>
                            <div>
                                <p class="mb-1 text-muted small">Description</p>
                                <p class="mb-0">{{ $besoin->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de traitement -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Traitement</h5>
                        </div>
                        <div class="card-body p-4">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('besoins.update', $besoin) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="form-label">Statut <span class="text-danger">*</span></label>
                                    <select name="statut" class="form-select" required>
                                        <option value="en_attente" {{ $besoin->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="en_cours" {{ $besoin->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="résolu" {{ $besoin->statut === 'résolu' ? 'selected' : '' }}>Résolu</option>
                                        <option value="rejeté" {{ $besoin->statut === 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Réponse / Commentaire</label>
                                    <textarea name="reponse" class="form-control" rows="5" 
                                              placeholder="Décrivez les actions prises ou la raison du rejet...">{{ old('reponse', $besoin->reponse) }}</textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn bg-rose">
                                        <i class='bx bx-check me-2'></i>Mettre à jour
                                    </button>
                                    <a href="{{ route('besoins.index') }}" class="btn btn-outline-secondary">
                                        <i class='bx bx-x me-2'></i>Annuler
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
