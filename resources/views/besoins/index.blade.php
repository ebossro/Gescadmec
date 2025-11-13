@extends('layout.app')

@section('title', 'Besoins des étudiants')

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
                    <h4 class="mb-0">Besoins</h4>
                    <p class="text-muted small mb-0">Gestion des besoins des étudiants</p>
                </div>
                <a href="{{ route('besoins.create') }}" class="btn bg-rose">
                    <i class='bx bx-plus me-2'></i>Nouveau besoin
                </a>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Filtres -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('besoins.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Statut</label>
                                <select name="statut" class="form-select">
                                    <option value="">Tous les statuts</option>
                                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="résolu" {{ request('statut') === 'résolu' ? 'selected' : '' }}>Résolu</option>
                                    <option value="rejeté" {{ request('statut') === 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Catégorie</label>
                                <select name="categorie" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    <option value="matériel" {{ request('categorie') === 'matériel' ? 'selected' : '' }}>Matériel</option>
                                    <option value="pédagogie" {{ request('categorie') === 'pédagogie' ? 'selected' : '' }}>Pédagogie</option>
                                    <option value="administratif" {{ request('categorie') === 'administratif' ? 'selected' : '' }}>Administratif</option>
                                    <option value="autre" {{ request('categorie') === 'autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn bg-rose me-2">
                                    <i class='bx bx-search me-2'></i>Filtrer
                                </button>
                                <a href="{{ route('besoins.index') }}" class="btn btn-outline-secondary">
                                    <i class='bx bx-reset'></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des besoins -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Étudiant</th>
                                    <th>Sujet</th>
                                    <th>Catégorie</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($besoins as $besoin)
                                <tr>
                                    <td>{{ $besoin->date_demande->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $besoin->etudiant->nom_complet }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $besoin->etudiant->telephone }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $besoin->sujet }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($besoin->description, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($besoin->categorie) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeColor = [
                                                'en_attente' => 'warning',
                                                'en_cours' => 'info',
                                                'résolu' => 'success',
                                                'rejeté' => 'danger'
                                            ][$besoin->statut];
                                        @endphp
                                        <span class="badge bg-{{ $badgeColor }}">{{ ucfirst(str_replace('_', ' ', $besoin->statut)) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('besoins.show', $besoin) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        @if($besoin->statut !== 'résolu' && $besoin->statut !== 'rejeté')
                                        <a href="{{ route('besoins.edit', $besoin) }}" class="btn btn-sm btn-outline-success" title="Traiter">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class='bx bx-message-x fs-1'></i>
                                        <p class="mb-0">Aucun besoin enregistré</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($besoins->hasPages())
                <div class="card-footer bg-white">
                    {{ $besoins->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
