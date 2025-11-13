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
        Schema::create('besoins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->string('sujet', 200);
            $table->text('description');
            $table->enum('categorie', ['matériel', 'pédagogie', 'administratif', 'autre'])->default('autre');
            $table->enum('statut', ['en_attente', 'en_cours', 'résolu', 'rejeté'])->default('en_attente');
            $table->date('date_demande');
            $table->date('date_traitement')->nullable();
            $table->text('reponse')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('besoins');
    }
};
