@extends('layout.app')

@section('title', 'Paiements')

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
                    <h4 class="mb-0">Paiements</h4>
                    <p class="text-muted small mb-0">Gestion des paiements et cumul par niveau</p>
                </div>
                <a href="{{ route('paiements.create') }}" class="btn bg-rose">
                    <i class='bx bx-plus me-2'></i>Nouveau paiement
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
                    <form method="GET" action="{{ route('paiements.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Niveau</label>
                                <select name="niveau_id" class="form-select">
                                    <option value="">Tous les niveaux</option>
                                    @foreach($niveaux as $niveau)
                                    <option value="{{ $niveau->id }}" {{ request('niveau_id') == $niveau->id ? 'selected' : '' }}>
                                        {{ $niveau->code }} - {{ $niveau->libelle }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date début</label>
                                <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date fin</label>
                                <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn bg-rose me-2">
                                    <i class='bx bx-search me-2'></i>Filtrer
                                </button>
                                <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
                                    <i class='bx bx-reset'></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des paiements -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class='bx bx-list-ul me-2'></i>Liste des paiements</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Reçu</th>
                                    <th>Date</th>
                                    <th>Étudiant</th>
                                    <th>Niveau</th>
                                    <th>Mode</th>
                                    <th class="text-end">Montant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                <tr>
                                    <td><strong>{{ $paiement->numero_recu }}</strong></td>
                                    <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                                    <td>{{ $paiement->inscription->etudiant->nom_complet }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $paiement->inscription->niveau->code }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ ucfirst($paiement->mode_paiement) }}</small>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('paiements.recu', $paiement) }}" class="btn btn-sm btn-outline-primary" title="Imprimer le reçu">
                                            <i class='bx bx-printer'></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class='bx bx-wallet fs-1'></i>
                                        <p class="mb-0">Aucun paiement enregistré</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($paiements->hasPages())
                <div class="card-footer bg-white">
                    {{ $paiements->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
