@extends('layout.app')

@section('title', 'Détails étudiant')

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
                    <h4 class="mb-0">{{ $etudiant->nom_complet }}</h4>
                    <p class="text-muted small mb-0">Détails de l'étudiant</p>
                </div>
                <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary">
                    <i class='bx bx-arrow-back me-2'></i>Retour
                </a>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <!-- Informations personnelles -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class='bx bx-user me-2'></i>Informations personnelles</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted">Nom:</td>
                                    <td><strong>{{ $etudiant->nom }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prénom:</td>
                                    <td><strong>{{ $etudiant->prenom }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Sexe:</td>
                                    <td>{{ $etudiant->sexe === 'M' ? 'Masculin' : 'Féminin' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Date de naissance:</td>
                                    <td>{{ $etudiant->date_naissance->format('d/m/Y') }}</td>
                                </tr>
                                @if($etudiant->lieu_naissance)
                                <tr>
                                    <td class="text-muted">Lieu de naissance:</td>
                                    <td>{{ $etudiant->lieu_naissance }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Téléphone:</td>
                                    <td><strong>{{ $etudiant->telephone }}</strong></td>
                                </tr>
                                @if($etudiant->email)
                                <tr>
                                    <td class="text-muted">Email:</td>
                                    <td>{{ $etudiant->email }}</td>
                                </tr>
                                @endif
                                @if($etudiant->adresse)
                                <tr>
                                    <td class="text-muted">Adresse:</td>
                                    <td>{{ $etudiant->adresse }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Nationalité:</td>
                                    <td>{{ $etudiant->nationalite }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Inscriptions et paiements -->
                <div class="col-md-8">
                    <!-- Inscriptions -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class='bx bx-book-reader me-2'></i>Inscriptions</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>N° Inscription</th>
                                            <th>Niveau</th>
                                            <th>Période</th>
                                            <th>Jours restants</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($etudiant->inscriptions as $inscription)
                                        <tr>
                                            <td><strong>{{ $inscription->numero_inscription }}</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $inscription->niveau->code }}</span>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $inscription->date_debut->format('d/m/Y') }}<br>
                                                    au {{ $inscription->date_fin->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $inscription->jours_restants }} jours</span>
                                            </td>
                                            <td>
                                                <div>{{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA</div>
                                                <small class="text-muted">/ {{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $inscription->statut_paiement === 'soldé' ? 'success' : ($inscription->statut_paiement === 'partiel' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($inscription->statut_paiement) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('etudiants.recu', $inscription) }}" class="btn btn-sm btn-outline-primary" title="Impimer le reçu">
                                                    <i class='bx bx-receipt'></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-3 text-muted">Aucune inscription</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Historique des paiements -->
                    @if($etudiant->inscriptions->first() && $etudiant->inscriptions->first()->paiements->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class='bx bx-money me-2'></i>Historique des paiements</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>N° Reçu</th>
                                            <th>Date</th>
                                            <th>Mode</th>
                                            <th class="text-end">Montant</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($etudiant->inscriptions as $inscription)
                                            @foreach($inscription->paiements as $paiement)
                                            <tr>
                                                <td><strong>{{ $paiement->numero_recu }}</strong></td>
                                                <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                                                <td><small>{{ ucfirst($paiement->mode_paiement) }}</small></td>
                                                <td class="text-end">
                                                    <strong class="text-success">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</strong>
                                                </td>
                                                <td>
                                                    <a href="{{ route('paiements.recu', $paiement) }}" class="btn btn-sm btn-outline-primary" title="Imprimer le reçu">
                                                        <i class='bx bx-receipt'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Besoins -->
                    @if($etudiant->besoins->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class='bx bx-message-square-detail me-2'></i>Besoins exprimés</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($etudiant->besoins as $besoin)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $besoin->sujet }}</h6>
                                            <p class="mb-1 small">{{ $besoin->description }}</p>
                                            <small class="text-muted">
                                                <i class='bx bx-calendar'></i> {{ $besoin->date_demande->format('d/m/Y') }} - 
                                                <span class="badge bg-secondary">{{ ucfirst($besoin->categorie) }}</span>
                                            </small>
                                        </div>
                                        <span class="badge bg-{{ $besoin->statut === 'résolu' ? 'success' : ($besoin->statut === 'en_cours' ? 'info' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $besoin->statut)) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="mt-4">
                <a href="{{ route('paiements.create', ['inscription_id' => $etudiant->inscriptions->first()?->id]) }}" class="btn btn-success me-2">
                    <i class='bx bx-money me-2'></i>Ajouter un paiement
                </a>
                <a href="{{ route('besoins.create', ['etudiant_id' => $etudiant->id]) }}" class="btn btn-primary">
                    <i class='bx bx-message-square-add me-2'></i>Nouveau besoin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
