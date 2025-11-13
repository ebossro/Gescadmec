<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Inscription;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    /**
     * Liste des paiements
     */
    public function index(Request $request)
    {
        $query = Paiement::with(['inscription.etudiant', 'inscription.niveau']);
        
        // Filtrer par niveau si spécifié
        if ($request->has('niveau_id') && $request->niveau_id) {
            $query->whereHas('inscription', function($q) use ($request) {
                $q->where('niveau_id', $request->niveau_id);
            });
        }
        
        // Filtrer par période si spécifiée
        if ($request->has('date_debut') && $request->date_debut) {
            $query->where('date_paiement', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && $request->date_fin) {
            $query->where('date_paiement', '<=', $request->date_fin);
        }
        
        $paiements = $query->orderBy('date_paiement', 'desc')->paginate(20);
        $niveaux = Niveau::where('actif', true)->get();
        
        // Statistiques par niveau
        $statistiques = Niveau::with('inscriptions')
            ->where('actif', true)
            ->get()
            ->map(function($niveau) {
                return [
                    'niveau' => $niveau,
                    'nb_etudiants' => $niveau->inscriptions()->count(),
                    'nb_payes' => $niveau->inscriptions()->where('statut_paiement', 'soldé')->count(),
                    'nb_impayes' => $niveau->inscriptions()->where('statut_paiement', 'impayé')->count(),
                    'montant_total' => $niveau->inscriptions()->sum('montant_total'),
                    'montant_verse' => $niveau->inscriptions()->sum('montant_verse'),
                    'solde_restant' => $niveau->inscriptions()->sum('solde_restant'),
                ];
            });
        
        return view('paiements.index', compact('paiements', 'niveaux', 'statistiques'));
    }

    /**
     * Formulaire d'ajout de paiement
     */
    public function create(Request $request)
    {
        $inscription_id = $request->get('inscription_id');
        $inscription = null;
        
        if ($inscription_id) {
            $inscription = Inscription::with(['etudiant', 'niveau'])
                ->findOrFail($inscription_id);
        }
        
        $inscriptions = Inscription::with(['etudiant', 'niveau'])
            ->where('solde_restant', '>', 0)
            ->get();
        
        return view('paiements.create', compact('inscriptions', 'inscription'));
    }

    /**
     * Enregistrer un nouveau paiement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:espèces,virement,mobile_money,chèque',
            'reference_transaction' => 'nullable|string|max:100',
            'observation' => 'nullable|string',
        ]);

        $inscription = Inscription::findOrFail($validated['inscription_id']);
        
        // Vérifier que le montant ne dépasse pas le solde restant
        if ($validated['montant'] > $inscription->solde_restant) {
            return back()->withErrors(['montant' => 'Le montant ne peut pas dépasser le solde restant (' . number_format($inscription->solde_restant, 0, ',', ' ') . ' FCFA)']);
        }

        // Créer le paiement
        $paiement = Paiement::create([
            'inscription_id' => $inscription->id,
            'numero_recu' => Paiement::genererNumeroRecu(),
            'date_paiement' => now(),
            'montant' => $validated['montant'],
            'mode_paiement' => $validated['mode_paiement'],
            'reference_transaction' => $validated['reference_transaction'],
            'user_id' => Auth::id(),
        ]);

        // Mettre à jour l'inscription
        $nouveau_montant_verse = $inscription->montant_verse + $validated['montant'];
        $nouveau_solde = $inscription->montant_total - $nouveau_montant_verse;
        
        $inscription->update([
            'montant_verse' => $nouveau_montant_verse,
            'solde_restant' => $nouveau_solde,
            'statut_paiement' => $nouveau_solde <= 0 ? 'soldé' : 'partiel',
        ]);

        return redirect()->route('paiements.recu', $paiement->id)
            ->with('success', 'Paiement enregistré avec succès!');
    }

    /**
     * Imprimer le reçu
     */
    public function recu(Paiement $paiement)
    {
        $paiement->load(['inscription.etudiant', 'inscription.niveau', 'secretaire']);
        return view('paiements.recu', compact('paiement'));
    }

}
