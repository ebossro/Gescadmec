@extends('layout.app')

@section('title', 'Liste des étudiants')

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
                    <h4 class="mb-0">Étudiants</h4>
                    <p class="text-muted small mb-0">Liste de tous les étudiants inscrits</p>
                </div>
                <a href="{{ route('etudiants.create') }}" class="btn bg-rose">
                    <i class='bx bx-plus me-2'></i>Nouvelle inscription
                </a>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Contact</th>
                                    <th>Niveau actuel</th>
                                    <th>Statut paiement</th>
                                    <th>Solde</th>
                                    <th>Jours restants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiants as $etudiant)
                                @php
                                    $inscription = $etudiant->inscriptions->first();
                                @endphp
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $etudiant->nom_complet }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class='bx bx-user'></i> {{ $etudiant->sexe === 'M' ? 'Masculin' : 'Féminin' }} - 
                                                {{ $etudiant->date_naissance->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <i class='bx bx-phone'></i> {{ $etudiant->telephone }}<br>
                                        @if($etudiant->email)
                                        <small class="text-muted"><i class='bx bx-envelope'></i> {{ $etudiant->email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inscription)
                                        <span class="badge bg-info">{{ $inscription->niveau->code }}</span>
                                        <br>
                                        <small class="text-muted">{{ $inscription->niveau->libelle }}</small>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inscription)
                                        <span class="badge bg-{{ $inscription->statut_paiement === 'soldé' ? 'success' : ($inscription->statut_paiement === 'partiel' ? 'warning' : 'danger') }}">
                                            {{ $inscription->statut_paiement }}
                                        </span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inscription)
                                        <strong class="text-{{ $inscription->solde_restant > 0 ? 'danger' : 'success' }}">
                                            {{ number_format($inscription->solde_restant, 0, ',', ' ') }} FCFA
                                        </strong>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inscription)
                                        <span class="badge bg-secondary">{{ $inscription->jours_restants }} jours</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('etudiants.show', $etudiant) }}" class="btn btn-sm btn-outline-primary">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <form action="{{ route('etudiants.destroy', $etudiant) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cet étudiant et toutes les données associées ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class='bx bx-user-x fs-1'></i>
                                        <p class="mb-0">Aucun étudiant inscrit</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($etudiants->hasPages())
                <div class="card-footer bg-white">
                    {{ $etudiants->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
