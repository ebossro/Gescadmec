<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BesoinController extends Controller
{
    /**
     * Liste des besoins
     */
    public function index(Request $request)
    {
        $query = Besoin::with(['etudiant', 'secretaire']);
        
        // Filtrer par statut
        if ($request->has('statut') && $request->statut) {
            $query->where('statut', $request->statut);
        }
        
        // Filtrer par catégorie
        if ($request->has('categorie') && $request->categorie) {
            $query->where('categorie', $request->categorie);
        }
        
        $besoins = $query->orderBy('date_demande', 'desc')->paginate(15);
        
        return view('besoins.index', compact('besoins'));
    }

    /**
     * Formulaire d'ajout de besoin
     */
    public function create(Request $request)
    {
        $etudiant_id = $request->get('etudiant_id');
        $etudiant = null;
        
        if ($etudiant_id) {
            $etudiant = Etudiant::findOrFail($etudiant_id);
        }
        
        $etudiants = Etudiant::orderBy('nom')->get();
        
        return view('besoins.create', compact('etudiants', 'etudiant'));
    }

    /**
     * Enregistrer un nouveau besoin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'sujet' => 'required|string|max:200',
            'description' => 'required|string',
            'categorie' => 'required|in:matériel,pédagogie,administratif,autre',
        ]);

        Besoin::create([
            'etudiant_id' => $validated['etudiant_id'],
            'sujet' => $validated['sujet'],
            'description' => $validated['description'],
            'categorie' => $validated['categorie'],
            'statut' => 'en_attente',
            'date_demande' => now(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('besoins.index')
            ->with('success', 'Besoin enregistré avec succès!');
    }

    /**
     * Afficher les détails d'un besoin
     */
    public function show(Besoin $besoin)
    {
        $besoin->load(['etudiant', 'secretaire']);
        return view('besoins.show', compact('besoin'));
    }

    /**
     * Formulaire de traitement d'un besoin
     */
    public function edit(Besoin $besoin)
    {
        $besoin->load(['etudiant']);
        return view('besoins.edit', compact('besoin'));
    }

    /**
     * Traiter/Mettre à jour un besoin
     */
    public function update(Request $request, Besoin $besoin)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,en_cours,résolu,rejeté',
            'reponse' => 'nullable|string',
        ]);

        $besoin->update([
            'statut' => $validated['statut'],
            'reponse' => $validated['reponse'],
            'date_traitement' => now(),
        ]);

        return redirect()->route('besoins.index')
            ->with('success', 'Besoin mis à jour avec succès!');
    }
}
