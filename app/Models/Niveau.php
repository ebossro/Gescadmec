<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $table = 'niveaux';

    protected $fillable = [
        'code',
        'libelle',
        'prix',
        'duree_jours',
        'description',
        'actif',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'duree_jours' => 'integer',
        'actif' => 'boolean',
    ];

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Nombre d'étudiants inscrits
     */
    public function nombreEtudiants()
    {
        return $this->inscriptions()->count();
    }

    /**
     * Montant total collecté pour ce niveau
     */
    public function montantCollecte()
    {
        return $this->inscriptions()->sum('montant_verse');
    }

    /**
     * Solde restant total pour ce niveau
     */
    public function soldeRestant()
    {
        return $this->inscriptions()->sum('solde_restant');
    }
}
