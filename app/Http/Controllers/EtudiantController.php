<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Inscription;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EtudiantController extends Controller
{
    /**
     * Liste des étudiants
     */
    public function index()
    {
        $etudiants = Etudiant::with(['inscriptions.niveau'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Pour chaque étudiant, on parcourt ses inscriptions
        foreach ($etudiants as $etudiant) {
            foreach ($etudiant->inscriptions as $inscription) {
                // Calcul de la durée totale
                $duree_totale = $inscription->date_debut->diffInDays($inscription->date_fin);

                // Calcul des jours restants
                $aujourdhui = Carbon::now();
                $jours_restants = $aujourdhui->greaterThan($inscription->date_fin)
                    ? 0
                    : $aujourdhui->diffInDays($inscription->date_fin);

                // Vérifier si la formation est soldée
                $est_solde = $inscription->solde_restant <= 0;

                // On ajoute ces valeurs au modèle
                $inscription->duree_totale = $duree_totale;
                $inscription->jours_restants = number_format($jours_restants);
                $inscription->est_solde = $est_solde;
            }
        }
        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Formulaire d'inscription d'un étudiant
     */
    public function create()
    {
        $niveaux = Niveau::where('actif', true)->get();
        return view('etudiants.create', compact('niveaux'));
    }

    /**
     * Enregistrer un nouvel étudiant et son inscription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:150',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'adresse' => 'nullable|string',
            'nationalite' => 'nullable|string|max:50',
            'niveau_id' => 'required|exists:niveaux,id',
            'date_debut' => 'required|date',
            'montant_verse' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:espèces,virement,mobile_money,chèque',
            'reference_transaction' => 'nullable|string|max:100',
        ]);

        // Créer l'étudiant
        $etudiant = Etudiant::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'sexe' => $validated['sexe'],
            'date_naissance' => $validated['date_naissance'],
            'lieu_naissance' => $validated['lieu_naissance'],
            'telephone' => $validated['telephone'],
            'email' => $validated['email'],
            'adresse' => $validated['adresse'],
            'nationalite' => $validated['nationalite'] ?? 'Togolaise',
        ]);

        // Récupérer le niveau
        $niveau = Niveau::findOrFail($validated['niveau_id']);
        
        // Calculer les dates
        $date_debut = Carbon::parse($validated['date_debut']);
        $date_fin = $date_debut->copy()->addDays($niveau->duree_jours);
        
        // Calculer le solde
        $montant_total = $niveau->prix;
        $montant_verse = $validated['montant_verse'];
        $solde_restant = $montant_total - $montant_verse;
        
        // Déterminer le statut de paiement
        if ($solde_restant <= 0) {
            $statut_paiement = 'soldé';
        } elseif ($montant_verse > 0) {
            $statut_paiement = 'partiel';
        } else {
            $statut_paiement = 'impayé';
        }

        // Générer un numéro d'inscription simple
        $annee = date('Y');
        $prochain_id = (Inscription::max('id') ?? 0) + 1; // on récupère le dernier id + 1
        $numero_inscription = 'INS-' . $annee . '-' . str_pad($prochain_id, 4, '0', STR_PAD_LEFT);

        // Créer l'inscription
        $inscription = Inscription::create([
            'etudiant_id' => $etudiant->id,
            'niveau_id' => $niveau->id,
            'numero_inscription' => $numero_inscription,
            'date_inscription' => now(),
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'montant_total' => $montant_total,
            'montant_verse' => $montant_verse,
            'solde_restant' => $solde_restant,
            'statut_paiement' => $statut_paiement,
            'statut_formation' => 'en_cours',
            'user_id' => Auth::id(),
        ]);

        // Si un paiement a été effectué, l'enregistrer
        if ($montant_verse > 0) {
            Paiement::create([
                'inscription_id' => $inscription->id,
                'numero_recu' => Paiement::genererNumeroRecu(),
                'date_paiement' => now(),
                'montant' => $montant_verse,
                'mode_paiement' => $validated['mode_paiement'],
                'reference_transaction' => $validated['reference_transaction'],
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('etudiants.recu', $inscription->id)
            ->with('success', 'Étudiant inscrit avec succès!');
    }

    /**
     * Afficher les détails d'un étudiant
     */
    public function show(Etudiant $etudiant)
    {
        // Charger les relations nécessaires
        $etudiant->load(['inscriptions.niveau', 'inscriptions.paiements', 'besoins']);

        // Pour chaque inscription, on calcule les infos à afficher
        foreach ($etudiant->inscriptions as $inscription) {
            // Calcul de la durée totale
            $duree_totale = $inscription->date_debut->diffInDays($inscription->date_fin);

            // Calcul des jours restants
            $aujourdhui = Carbon::now();
            if ($aujourdhui->greaterThan($inscription->date_fin)) {
                $jours_restants = 0;
            } else {
                $jours_restants = number_format($aujourdhui->diffInDays($inscription->date_fin));
            }

            // Vérification du statut de paiement
            $est_solde = $inscription->solde_restant <= 0;

            // On ajoute ces valeurs au modèle (pour les afficher facilement dans Blade)
            $inscription->duree_totale = $duree_totale;
            $inscription->jours_restants = $jours_restants;
            $inscription->est_solde = $est_solde;
        }

        return view('etudiants.show', compact('etudiant'));
    }


    /**
     * Supprimer un étudiant et toutes les données associées
     */
    public function destroy(Etudiant $etudiant)
    {
        
        // Supprimer les paiements liés aux inscriptions
        foreach ($etudiant->inscriptions as $inscription) {
            $inscription->paiements()->delete();
        }

        // Supprimer les inscriptions
        $etudiant->inscriptions()->delete();

        // Supprimer les besoins
        $etudiant->besoins()->delete();

        // Supprimer l'étudiant
        $etudiant->delete();
        

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès ainsi que toutes les données associées.');
    }

    /**
     * Générer et afficher le reçu d'inscription
     */
    public function recu(Inscription $inscription)
    {
        $inscription->load(['etudiant', 'niveau', 'paiements.secretaire']);
        return view('etudiants.recu', compact('inscription'));
    }
}
