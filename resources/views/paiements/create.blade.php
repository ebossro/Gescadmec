@extends('layout.app')

@section('title', 'Nouveau paiement')

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
            <h4 class="mb-0">Nouveau paiement</h4>
            <p class="text-muted small mb-0">Enregistrer un paiement</p>
        </div>

        <div class="p-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
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

                            <form action="{{ route('paiements.store') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label">Inscription <span class="text-danger">*</span></label>
                                    <select name="inscription_id" id="inscription_id" class="form-select" required>
                                        <option value="">Sélectionner une inscription...</option>
                                        @foreach($inscriptions as $insc)
                                        <option value="{{ $insc->id }}" 
                                                data-solde="{{ $insc->solde_restant }}"
                                                data-etudiant="{{ $insc->etudiant->nom_complet }}"
                                                data-niveau="{{ $insc->niveau->code }}"
                                                {{ (old('inscription_id') ?? $inscription?->id) == $insc->id ? 'selected' : '' }}>
                                            {{ $insc->numero_inscription }} - {{ $insc->etudiant->nom_complet }} 
                                            ({{ $insc->niveau->code }}) - Solde: {{ number_format($insc->solde_restant, 0, ',', ' ') }} FCFA
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($inscription)
                                <div class="alert alert-info mb-4">
                                    <h6 class="mb-2">Informations de l'inscription</h6>
                                    <ul class="mb-0">
                                        <li>Étudiant: <strong>{{ $inscription->etudiant->nom_complet }}</strong></li>
                                        <li>Niveau: <strong>{{ $inscription->niveau->code }}</strong></li>
                                        <li>Montant total: <strong>{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</strong></li>
                                        <li>Déjà versé: <strong>{{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA</strong></li>
                                        <li>Solde restant: <strong class="text-danger">{{ number_format($inscription->solde_restant, 0, ',', ' ') }} FCFA</strong></li>
                                    </ul>
                                </div>
                                @endif

                                <div id="info_inscription" class="alert alert-info" style="display: none;">
                                    <h6 class="mb-2">Informations de l'inscription sélectionnée</h6>
                                    <ul class="mb-0">
                                        <li>Étudiant: <strong id="info_etudiant">-</strong></li>
                                        <li>Niveau: <strong id="info_niveau">-</strong></li>
                                        <li>Solde restant: <strong id="info_solde" class="text-danger">0 FCFA</strong></li>
                                    </ul>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Montant <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="montant" id="montant" class="form-control" 
                                                   value="{{ old('montant') }}" min="0" step="1000" required>
                                            <span class="input-group-text">FCFA</span>
                                        </div>
                                        <small class="text-muted" id="solde_apres">Solde après paiement: <strong>0 FCFA</strong></small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mode de paiement <span class="text-danger">*</span></label>
                                        <select name="mode_paiement" class="form-select" required>
                                            <option value="espèces" {{ old('mode_paiement') === 'espèces' ? 'selected' : '' }}>Espèces</option>
                                            <option value="virement" {{ old('mode_paiement') === 'virement' ? 'selected' : '' }}>Virement bancaire</option>
                                            <option value="mobile_money" {{ old('mode_paiement') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                            <option value="chèque" {{ old('mode_paiement') === 'chèque' ? 'selected' : '' }}>Chèque</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Référence de transaction</label>
                                    <input type="text" name="reference_transaction" class="form-control" 
                                           value="{{ old('reference_transaction') }}" placeholder="Numéro de transaction (optionnel)">
                                </div>


                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn bg-rose">
                                        <i class='bx bx-save me-2'></i>Enregistrer le paiement
                                    </button>
                                    <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inscriptionSelect = document.getElementById('inscription_id');
    const montantInput = document.getElementById('montant');
    const infoInscription = document.getElementById('info_inscription');
    
    function updateInfo() {
        const selectedOption = inscriptionSelect.options[inscriptionSelect.selectedIndex];
        if (!selectedOption.value) {
            infoInscription.style.display = 'none';
            return;
        }
        
        const solde = parseFloat(selectedOption.dataset.solde);
        const etudiant = selectedOption.dataset.etudiant;
        const niveau = selectedOption.dataset.niveau;
        
        document.getElementById('info_etudiant').textContent = etudiant;
        document.getElementById('info_niveau').textContent = niveau;
        document.getElementById('info_solde').textContent = solde.toLocaleString('fr-FR') + ' FCFA';
        
        infoInscription.style.display = 'block';
        
        calculerSoldeApres(solde);
    }
    
    function calculerSoldeApres(soldeActuel) {
        const montant = parseFloat(montantInput.value) || 0;
        const nouveauSolde = soldeActuel - montant;
        const soldeApresEl = document.getElementById('solde_apres');
        soldeApresEl.innerHTML = 'Solde après paiement: <strong class="' + 
            (nouveauSolde > 0 ? 'text-danger' : 'text-success') + '">' + 
            nouveauSolde.toLocaleString('fr-FR') + ' FCFA</strong>';
    }
    
    inscriptionSelect.addEventListener('change', updateInfo);
    montantInput.addEventListener('input', function() {
        const selectedOption = inscriptionSelect.options[inscriptionSelect.selectedIndex];
        if (selectedOption.value) {
            const solde = parseFloat(selectedOption.dataset.solde);
            calculerSoldeApres(solde);
        }
    });
    
    // Initialiser si une inscription est déjà sélectionnée
    if (inscriptionSelect.value) {
        updateInfo();
    }
});
</script>
@endsection
