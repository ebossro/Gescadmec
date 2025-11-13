@extends('layout.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="d-flex">
        <!-- Sidebar -->
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


    <!-- Main Content -->
    <div class="flex-grow-1" style="background-color: #f8f9fa;">
        <!-- Header -->
        <div class="bg-white border-bottom px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Tableau de bord</h4>
                    <p class="text-muted small mb-0">Interface Secrétaire</p>
                </div>
                <div class="text-end">
                    <p class="mb-0 small">Connecté en tant que</p>
                    <strong>{{ Auth::user()->name }}</strong>
                    <br>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Cartes statistiques -->
            <div class="row g-3 mb-4">
                <!-- Total Étudiants -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-white-50 mb-2">Total Étudiants</h6>
                                    <h2 class="mb-0">{{ $totalEtudiants }}</h2>
                                    <small>{{ $etudiantsPayes }} payés, {{ $etudiantsImpayes }} impayés</small>
                                </div>
                                <i class='bx bx-group fs-1 opacity-50'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Collectée -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: white;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-white-50 mb-2">Revenue Collectée</h6>
                                    <h2 class="mb-0">{{ number_format($revenuCollecte, 0, ',', ' ') }}F</h2>
                                    <small>Montants versés</small>
                                </div>
                                <i class='bx bx-money fs-1 opacity-50'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solde Impayé -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%); color: white;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-white-50 mb-2">Solde Impayé</h6>
                                    <h2 class="mb-0">{{ number_format($soldeImpaye, 0, ',', ' ') }}F</h2>
                                    <small>À recouvrer</small>
                                </div>
                                <i class='bx bx-error-circle fs-1 opacity-50'></i>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Statistiques par niveau -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class='bx bx-bar-chart-alt-2 me-2'></i>Répartition par niveau</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Niveau</th>
                                    <th>Nombre d'étudiants</th>
                                    <th>Montant collecté</th>
                                    <th>Solde restant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statistiquesNiveaux as $stat)
                                <tr>
                                    <td>
                                        <strong>{{ $stat['niveau']->code }}</strong> - {{ $stat['niveau']->libelle }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $stat['nb_etudiants'] }}</span>
                                    </td>
                                    <td class="text-success">
                                        <strong>{{ number_format($stat['montant_collecte'], 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td class="text-danger">
                                        {{ number_format($stat['solde_restant'], 0, ',', ' ') }} FCFA
                                    </td>
                                    <td>
                                        @php
                                            $total = $stat['montant_collecte'] + $stat['solde_restant'];
                                            $taux = $total > 0 ? ($stat['montant_collecte'] / $total) * 100 : 0;
                                        @endphp
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Aucune donnée disponible
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Dernières inscriptions -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class='bx bx-user-plus me-2'></i>Dernières inscriptions</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($dernieresInscriptions as $inscription)
                                <a href="{{ route('etudiants.show', $inscription->etudiant_id) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $inscription->etudiant->nom_complet }}</h6>
                                            <small class="text-muted">
                                                <i class='bx bx-book-reader'></i> {{ $inscription->niveau->code }} - 
                                                <i class='bx bx-calendar'></i> {{ $inscription->date_inscription->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-{{ $inscription->statut_paiement === 'soldé' ? 'success' : ($inscription->statut_paiement === 'partiel' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($inscription->statut_paiement) }}
                                        </span>
                                    </div>
                                </a>
                                @empty
                                <div class="p-4 text-center text-muted">
                                    Aucune inscription récente
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Derniers paiements -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class='bx bx-money me-2'></i>Derniers paiements</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($derniersPaiements as $paiement)
                                <a href="{{ route('paiements.recu', $paiement->id) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $paiement->inscription->etudiant->nom_complet }}</h6>
                                            <small class="text-muted">
                                                <i class='bx bx-receipt'></i> {{ $paiement->numero_recu }} - 
                                                <i class='bx bx-calendar'></i> {{ $paiement->date_paiement->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-success">
                                            {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>
                                </a>
                                @empty
                                <div class="p-4 text-center text-muted">
                                    Aucun paiement récent
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



