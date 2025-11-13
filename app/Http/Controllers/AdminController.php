<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Besoin;
use App\Models\Niveau;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalEtudiants = Etudiant::count();
        $totalInscriptions = Inscription::count();
        $etudiantsPayes = Inscription::where('statut_paiement', 'soldé')->count();
        $etudiantsImpayes = Inscription::where('statut_paiement', 'impayé')->count();
        
        // Revenus
        $revenuCollecte = Inscription::sum('montant_verse');
        $soldeImpaye = Inscription::sum('solde_restant');
        
        // Statistiques par niveau
        $statistiquesNiveaux = Niveau::with('inscriptions')
            ->where('actif', true)
            ->get()
            ->map(function($niveau) {
                return [
                    'niveau' => $niveau,
                    'nb_etudiants' => $niveau->inscriptions()->count(),
                    'montant_collecte' => $niveau->inscriptions()->sum('montant_verse'),
                    'solde_restant' => $niveau->inscriptions()->sum('solde_restant'),
                ];
            });
        
        // Dernières inscriptions
        $dernieresInscriptions = Inscription::with(['etudiant', 'niveau'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Derniers paiements
        $derniersPaiements = Paiement::with(['inscription.etudiant', 'inscription.niveau'])
            ->orderBy('date_paiement', 'desc')
            ->limit(5)
            ->get();
        
        return view('front.admin', compact(
            'totalEtudiants',
            'etudiantsPayes',
            'etudiantsImpayes',
            'revenuCollecte',
            'soldeImpaye',
            'statistiquesNiveaux',
            'dernieresInscriptions',
            'derniersPaiements'
        ));
    }
}
