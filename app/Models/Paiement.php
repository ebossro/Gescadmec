<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'inscription_id',
        'numero_recu',
        'date_paiement',
        'montant',
        'mode_paiement',
        'reference_transaction',
        'user_id',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'decimal:2',
    ];

    /**
     * Relation avec l'inscription
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    /**
     * Relation avec l'utilisateur (secrétaire)
     */
    public function secretaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Générer un numéro de reçu unique
     */
    public static function genererNumeroRecu()
    {
        $annee = date('Y');
        $dernier = self::whereYear('created_at', $annee)
            ->orderBy('id', 'desc')
            ->first();
        
        $numero = $dernier ? intval(substr($dernier->numero_recu, -4)) + 1 : 1;
        
        return 'REC-' . $annee . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}
