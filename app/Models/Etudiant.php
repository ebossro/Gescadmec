<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'email',
        'adresse',
        'nationalite',
    ];

    /**
     * Casts
     *
     * Assure que `date_naissance` est une instance de Carbon afin de pouvoir
     * appeler ->format(...) depuis les vues.
     */
    protected $casts = [
        'date_naissance' => 'date',
    ];

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Relation avec les besoins
     */
    public function besoins()
    {
        return $this->hasMany(Besoin::class);
    }

    /**
     * Nom complet de l'étudiant
     */
    public function getNomCompletAttribute()
    {
        return trim(($this->nom ?? '') . ' ' . ($this->prenom ?? ''));
    }

    // /**
    //  * Âge de l'étudiant
    //  */
    public function getAgeAttribute()
    {
        return $this->date_naissance->age;
    }
}
