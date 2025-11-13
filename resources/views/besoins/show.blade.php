@extends('layout.app')

@section('title', 'Détails du besoin')

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
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Détails du besoin</h4>
                    <p class="text-muted small mb-0">{{ $besoin->sujet }}</p>
                </div>
                <div>
                    <a href="{{ route('besoins.index') }}" class="btn btn-outline-secondary me-2">
                        <i class='bx bx-arrow-back me-2'></i>Retour
                    </a>
                    @if($besoin->statut !== 'résolu' && $besoin->statut !== 'rejeté')
                    <a href="{{ route('besoins.edit', $besoin) }}" class="btn btn-primary">
                        <i class='bx bx-edit me-2'></i>Traiter
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <!-- Informations principales -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-4" >
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class='bx bx-info-circle me-2'></i>Informations du besoin</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Sujet</h6>
                                <h4 class="mb-0">{{ $besoin->sujet }}</h4>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Description</h6>
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $besoin->description }}</p>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Catégorie</h6>
                                    <span class="badge bg-secondary fs-6">
                                        <i class='bx bx-category me-1'></i>{{ ucfirst($besoin->categorie) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Statut</h6>
                                @php
                                    $statusBadge = [
                                        'en_attente' => 'warning',
                                        'en_cours' => 'info',
                                        'résolu' => 'success',
                                        'rejeté' => 'danger'
                                    ][$besoin->statut];
                                @endphp
                                <span class="badge bg-{{ $statusBadge }} fs-6">
                                    <i class='bx bx-time-five me-1'></i>{{ ucfirst(str_replace('_', ' ', $besoin->statut)) }}
                                </span>
                            </div>

                            @if($besoin->reponse)
                            <div class="alert alert-{{ $besoin->statut === 'résolu' ? 'success' : ($besoin->statut === 'rejeté' ? 'danger' : 'info') }}">
                                <h6 class="mb-2">
                                    <i class='bx bx-message-square-detail me-2'></i>Réponse / Commentaire
                                </h6>
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $besoin->reponse }}</p>
                                @if($besoin->date_traitement)
                                <hr class="my-2">
                                <small class="text-muted">
                                    <i class='bx bx-calendar me-1'></i>Traité le {{ $besoin->date_traitement->format('d/m/Y') }}
                                </small>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Historique / Timeline -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class='bx bx-history me-2'></i>Historique</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="d-flex mb-4">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class='bx bx-plus'></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Demande créée</h6>
                                        <p class="text-muted mb-0 small">
                                            <i class='bx bx-calendar me-1'></i>{{ $besoin->date_demande->format('d/m/Y à H:i') }}
                                        </p>
                                        @if($besoin->secretaire)
                                        <p class="text-muted mb-0 small">
                                            <i class='bx bx-user me-1'></i>Par {{ $besoin->secretaire->name }}
                                        </p>
                                        @endif
                                    </div>
                                </div>

                                @if($besoin->date_traitement)
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-{{ $statusBadge }} text-white d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class='bx bx-check'></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Besoin traité - {{ ucfirst(str_replace('_', ' ', $besoin->statut)) }}</h6>
                                        <p class="text-muted mb-0 small">
                                            <i class='bx bx-calendar me-1'></i>{{ $besoin->date_traitement->format('d/m/Y à H:i') }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations étudiant -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class='bx bx-user me-2'></i>Étudiant</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 80px; height: 80px;">
                                    <i class='bx bx-user fs-1 text-primary'></i>
                                </div>
                                <h5 class="mb-1">{{ $besoin->etudiant->nom_complet }}</h5>
                            </div>

                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 100px;">
                                        <i class='bx bx-phone me-1'></i>Téléphone:
                                    </td>
                                    <td>{{ $besoin->etudiant->telephone }}</td>
                                </tr>
                                @if($besoin->etudiant->email)
                                <tr>
                                    <td class="text-muted">
                                        <i class='bx bx-envelope me-1'></i>Email:
                                    </td>
                                    <td>{{ $besoin->etudiant->email }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">
                                        <i class='bx bx-calendar me-1'></i>Né(e) le:
                                    </td>
                                    <td>{{ $besoin->etudiant->date_naissance->format('d/m/Y') }}</td>
                                </tr>
                                @if($besoin->etudiant->adresse)
                                <tr>
                                    <td class="text-muted">
                                        <i class='bx bx-map me-1'></i>Adresse:
                                    </td>
                                    <td>{{ $besoin->etudiant->adresse }}</td>
                                </tr>
                                @endif
                            </table>

                            <div class="d-grid mt-3">
                                <a href="{{ route('etudiants.show', $besoin->etudiant) }}" class="btn btn-outline-primary">
                                    <i class='bx bx-user-circle me-2'></i>Voir le profil
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class='bx bx-cog me-2'></i>Actions</h5>
                        </div>
                        <div class="card-body">
                            @if($besoin->statut !== 'résolu' && $besoin->statut !== 'rejeté')
                            <div class="d-grid gap-2">
                                <a href="{{ route('besoins.edit', $besoin) }}" class="btn btn-success">
                                    <i class='bx bx-check me-2'></i>Traiter le besoin
                                </a>
                            </div>
                            @else
                            <div class="alert alert-{{ $besoin->statut === 'résolu' ? 'success' : 'danger' }} mb-0">
                                <i class='bx bx-info-circle me-2'></i>
                                Ce besoin a été {{ $besoin->statut === 'résolu' ? 'résolu' : 'rejeté' }}
                            </div>
                            @endif

                            <hr class="my-3">

                            <div class="d-grid">
                                <a href="{{ route('besoins.index') }}" class="btn btn-outline-secondary">
                                    <i class='bx bx-list-ul me-2'></i>Liste des besoins
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    bottom: 0;
    width: 2px;
    background-color: #e5e7eb;
}
</style>
@endsection
