@extends('layout.app')

@section('title', "Reçu d'inscription")

@section('content')
<div class="container py-4">
    <div class="text-end mb-3 d-print-none">
        <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary me-2">
            <i class='bx bx-arrow-back me-1'></i>Retour
        </a>
        <button onclick="window.print()" class="btn bg-rose">
            <i class='bx bx-printer me-1'></i>Imprimer
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-5 py-4">
            
            <!-- En-tête -->
            <div class="text-center border-bottom pb-3 mb-3">
                <h2 style="color:#ff385c; font-weight:bold;">GESCADMEC</h2>
                <p class="text-muted small mb-0">École de Langue Allemande - Lomé, Togo</p>
            </div>

            <!-- Titre -->
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-0">REÇU D’INSCRIPTION</h4>
                <p class="text-muted">N° {{ $inscription->numero_inscription }}</p>
            </div>

            <!-- Infos principales -->
            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="text-muted fw-semibold mb-2">Étudiant</h6>
                    <p class="mb-1"><strong>Nom : {{ $inscription->etudiant->nom_complet }}</strong></p>
                    <p class="mb-1">Tél : {{ $inscription->etudiant->telephone }}</p>
                    <p class="mb-0">Email : {{ $inscription->etudiant->email ?? '—' }}</p>
                </div>
                <div class="col-6">
                    <h6 class="text-muted fw-semibold mb-2">Formation</h6>
                    <p class="mb-1"><strong>{{ $inscription->niveau->libelle }}</strong></p>
                    <p class="mb-1">Début : {{ $inscription->date_debut->format('d/m/Y') }}</p>
                    <p class="mb-0">Fin : {{ $inscription->date_fin->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Tableau des montants -->
            <table class="table table-bordered align-middle">
                <tr>
                    <th>Montant total</th>
                    <td class="text-end">{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="table-success">
                    <th>Montant versé</th>
                    <td class="text-end fw-bold text-success">{{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="{{ $inscription->solde_restant > 0 ? 'table-warning' : 'table-success' }}">
                    <th>Solde restant</th>
                    <td class="text-end fw-bold">{{ number_format($inscription->solde_restant, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>

            <!-- Historique des paiements -->
            @if($inscription->paiements->count() > 0)
            <h6 class="mt-4 mb-2 text-muted fw-semibold">Historique des paiements</h6>
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Mode</th>
                        <th class="text-end">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscription->paiements as $p)
                    <tr>
                        <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($p->mode_paiement) }}</td>
                        <td class="text-end">{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <!-- Pied de page -->
            <div class="row mt-4 pt-3 border-top">
                <div class="col-6">
                    <p class="small text-muted mb-0">Émis le {{ now()->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="small text-muted mb-1">Signature et cachet</p>
                    <div class="mt-5 pt-3" style="border-top: 1px solid #000; width: 200px; margin-left: auto;"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media print {
    body { background: white !important; }
    .d-print-none { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection
