@extends('layout.app')

@section('title', 'Nouveau besoin')

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
            <h4 class="mb-0">Nouveau besoin</h4>
            <p class="text-muted small mb-0">Enregistrer un besoin d'étudiant</p>
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

                            <form action="{{ route('besoins.store') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                                    <select name="etudiant_id" class="form-select" required>
                                        <option value="">Sélectionner un étudiant...</option>
                                        @foreach($etudiants as $etud)
                                        <option value="{{ $etud->id }}" 
                                                {{ (old('etudiant_id') ?? $etudiant?->id) == $etud->id ? 'selected' : '' }}>
                                            {{ $etud->nom_complet }} - {{ $etud->telephone }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Sujet <span class="text-danger">*</span></label>
                                    <input type="text" name="sujet" class="form-control" 
                                           value="{{ old('sujet') }}" required 
                                           placeholder="Titre court du besoin">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="5" required 
                                              placeholder="Décrivez le besoin en détail...">{{ old('description') }}</textarea>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                                        <select name="categorie" class="form-select" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="matériel" {{ old('categorie') === 'matériel' ? 'selected' : '' }}>Matériel</option>
                                            <option value="pédagogie" {{ old('categorie') === 'pédagogie' ? 'selected' : '' }}>Pédagogie</option>
                                            <option value="administratif" {{ old('categorie') === 'administratif' ? 'selected' : '' }}>Administratif</option>
                                            <option value="autre" {{ old('categorie') === 'autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn bg-rose">
                                        <i class='bx bx-save me-2'></i>Enregistrer le besoin
                                    </button>
                                    <a href="{{ route('besoins.index') }}" class="btn btn-outline-secondary">
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
@endsection
