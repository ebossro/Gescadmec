<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('niveau_id')->constrained('niveaux')->onDelete('cascade');
            $table->string('numero_inscription', 50)->unique(); // Format: INS-2024-0001
            $table->date('date_inscription');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->decimal('montant_total', 10, 2);
            $table->decimal('montant_verse', 10, 2)->default(0);
            $table->decimal('solde_restant', 10, 2);
            $table->enum('statut_paiement', ['impayé', 'partiel', 'soldé'])->default('impayé');
            $table->enum('statut_formation', ['en_cours', 'terminé', 'abandonné'])->default('en_cours');
            $table->text('observation')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Secrétaire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
