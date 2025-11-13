@extends('layout.app')

@section('title', 'Inscrire un étudiant')

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
            <h4 class="mb-0">Nouvelle inscription</h4>
            <p class="text-muted small mb-0">Enregistrer un nouvel étudiant</p>
        </div>

        <div class="p-4">
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

                    <form action="{{ route('etudiants.store') }}" method="POST">
                        @csrf

                        <!-- Informations personnelles -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class='bx bx-user me-2'></i>Informations personnelles
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                    <select name="sexe" class="form-select" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                    <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Lieu de naissance</label>
                                    <input type="text" name="lieu_naissance" class="form-control" value="{{ old('lieu_naissance') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" name="telephone" class="form-control" value="{{ old('telephone') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Adresse</label>
                                    <textarea name="adresse" class="form-control" rows="2">{{ old('adresse') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nationalité</label>
                                    <input type="text" name="nationalite" class="form-control" value="{{ old('nationalite', 'Togolaise') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Informations de formation -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class='bx bx-book-reader me-2'></i>Formation
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Niveau souhaité <span class="text-danger">*</span></label>
                                    <select name="niveau_id" id="niveau_id" class="form-select" required>
                                        <option value="">Sélectionner un niveau...</option>
                                        @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}" 
                                                data-prix="{{ $niveau->prix }}"
                                                data-duree="{{ $niveau->duree_jours }}"
                                                {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                                            {{ $niveau->code }} - {{ $niveau->libelle }} ({{ number_format($niveau->prix, 0, ',', ' ') }} FCFA)
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date de début <span class="text-danger">*</span></label>
                                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ old('date_debut', date('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-12">
                                    <div class="alert alert-info" id="info_niveau" style="display: none;">
                                        <strong>Informations du niveau:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Montant total: <strong id="montant_total_text">0 FCFA</strong></li>
                                            <li>Durée: <strong id="duree_text">0 jours</strong></li>
                                            <li>Date de fin estimée: <strong id="date_fin_text">-</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations de paiement -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class='bx bx-money me-2'></i>Paiement initial
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Montant versé <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="montant_verse" id="montant_verse" class="form-control" value="{{ old('montant_verse', 0) }}" min="0" step="1000" required>
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                    <small class="text-muted">Solde restant: <strong id="solde_restant">0 FCFA</strong></small>
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

                                <div class="col-md-12">
                                    <label class="form-label">Référence de transaction</label>
                                    <input type="text" name="reference_transaction" class="form-control" value="{{ old('reference_transaction') }}" placeholder="Numéro de transaction (optionnel)">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn bg-rose">
                                <i class='bx bx-save me-2'></i>Enregistrer l'inscription
                            </button>
                            <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary">
                                <i class='bx bx-x me-2'></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const niveauSelect = document.getElementById('niveau_id');
    const montantVerseInput = document.getElementById('montant_verse');
    const dateDebutInput = document.getElementById('date_debut');
    const infoNiveau = document.getElementById('info_niveau');
    
    function calculerDates() {
        const selectedOption = niveauSelect.options[niveauSelect.selectedIndex];
        if (!selectedOption.value) {
            infoNiveau.style.display = 'none';
            return;
        }
        
        const prix = parseFloat(selectedOption.dataset.prix);
        const duree = parseInt(selectedOption.dataset.duree);
        const dateDebut = new Date(dateDebutInput.value);
        
        // Calculer date de fin
        const dateFin = new Date(dateDebut);
        dateFin.setDate(dateFin.getDate() + duree);
        
        // Afficher les informations
        document.getElementById('montant_total_text').textContent = prix.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('duree_text').textContent = duree + ' jours';
        document.getElementById('date_fin_text').textContent = dateFin.toLocaleDateString('fr-FR');
        
        infoNiveau.style.display = 'block';
        
        calculerSolde(prix);
    }
    
    function calculerSolde(prix) {
        const montantVerse = parseFloat(montantVerseInput.value) || 0;
        const solde = prix - montantVerse;
        document.getElementById('solde_restant').textContent = solde.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('solde_restant').className = solde > 0 ? 'text-danger fw-bold' : 'text-success fw-bold';
    }
    
    niveauSelect.addEventListener('change', calculerDates);
    dateDebutInput.addEventListener('change', calculerDates);
    montantVerseInput.addEventListener('input', calculerDates);
    
    // Initialiser si un niveau est déjà sélectionné
    if (niveauSelect.value) {
        calculerDates();
    }
});
</script>
@endsection
