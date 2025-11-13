@extends('layout.app')

@section('title', 'Reçu de paiement')

@section('content')
<div class="container py-4">
    <!-- Boutons (non imprimés) -->
    <div class="text-end mb-3 d-print-none">
        <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bx bx-arrow-back me-1"></i>Retour
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bx bx-printer me-1"></i>Imprimer
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-5 py-4">
            <!-- En-tête -->
            <div class="text-center border-bottom pb-3 mb-4">
                <h2 style="color:#ff385c; font-weight:bold;">GESCADMEC</h2>
                <p class="text-muted small mb-0">École de Langue Allemande - Lomé, Togo</p>
            </div>

            <!-- Titre -->
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-0">REÇU DE PAIEMENT</h4>
                <p class="text-muted">N° {{ $paiement->numero_recu }}</p>
            </div>

            <!-- Informations principales -->
            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="text-muted fw-semibold mb-2">Étudiant</h6>
                    <p class="mb-1">Nom : <strong>{{ $paiement->inscription->etudiant->nom_complet }}</strong></p>
                    <p class="mb-1">Tél : {{ $paiement->inscription->etudiant->telephone }}</p>
                    <p class="mb-0">Niveau : {{ $paiement->inscription->niveau->libelle }}</p>
                </div>
                <div class="col-6">
                    <h6 class="text-muted fw-semibold mb-2">Paiement</h6>
                    <p class="mb-1">Date : <strong>{{ $paiement->date_paiement->format('d/m/Y') }}</strong></p>
                    <p class="mb-1">Mode : {{ ucfirst($paiement->mode_paiement) }}</p>
                    <p class="mb-0">Reçu par : {{ $paiement->secretaire->name ?? 'Secrétaire' }}</p>
                </div>
            </div>

            <!-- Montant -->
            <div class="p-3 bg-success bg-opacity-10 border border-success rounded mb-4">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h6 class="mb-0 text-muted">Montant payé</h6>
                    </div>
                    <div class="col-6 text-end">
                        <h2 class="text-success mb-0">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</h2>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif -->
            <table class="table table-bordered align-middle">
                <tr>
                    <th>Montant total formation</th>
                    <td class="text-end">{{ number_format($paiement->inscription->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <th>Total versé à ce jour</th>
                    <td class="text-end fw-bold">{{ number_format($paiement->inscription->montant_verse, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="{{ $paiement->inscription->solde_restant > 0 ? 'table-warning' : 'table-success' }}">
                    <th>Solde restant</th>
                    <td class="text-end fw-bold">{{ number_format($paiement->inscription->solde_restant, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>

            <!-- Message -->
            @if($paiement->inscription->solde_restant > 0)
            <div class="alert alert-warning mt-3">
                <strong><i class="bx bx-info-circle"></i> Rappel :</strong>
                Il reste à payer {{ number_format($paiement->inscription->solde_restant, 0, ',', ' ') }} FCFA.
            </div>
            @else
            <div class="alert alert-success mt-3">
                <strong><i class="bx bx-check-circle"></i> Formation soldée :</strong>
                Tous les paiements ont été effectués.
            </div>
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

            <!-- Note -->
            <p class="small text-center text-muted mt-4 mb-0">
                Merci pour votre paiement — conservez ce reçu comme preuve officielle.
            </p>
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
