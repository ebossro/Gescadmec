<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Besoin extends Model
{
    use HasFactory;

    protected $table = 'besoins';

    protected $fillable = [
        'etudiant_id',
        'sujet',
        'description',
        'categorie',
        'priorite',
        'statut',
        'date_demande',
        'date_traitement',
        'reponse',
        'user_id',
    ];

    protected $casts = [
        'date_demande' => 'date',
        'date_traitement' => 'date',
    ];

    /**
     * Relation avec l'étudiant
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Relation avec l'utilisateur (secrétaire)
     */
    public function secretaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
