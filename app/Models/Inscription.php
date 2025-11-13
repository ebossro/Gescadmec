<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inscription extends Model
{
    use HasFactory;

    protected $table = 'inscriptions';

    protected $fillable = [
        'etudiant_id',
        'niveau_id',
        'numero_inscription',
        'date_inscription',
        'date_debut',
        'date_fin',
        'montant_total',
        'montant_verse',
        'solde_restant',
        'statut_paiement',
        'statut_formation',
        'observation',
        'user_id',
    ];

    protected $casts = [
        'date_inscription' => 'date',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'montant_total' => 'decimal:2',
        'montant_verse' => 'decimal:2',
        'solde_restant' => 'decimal:2',
    ];

    /**
     * Relation avec l'étudiant
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Relation avec le niveau
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Relation avec les paiements
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Relation avec l'utilisateur (secrétaire)
     */
    public function secretaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
