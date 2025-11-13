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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_id')->constrained('inscriptions')->onDelete('cascade');
            $table->string('numero_recu', 50)->unique(); // Format: REC-2024-0001
            $table->date('date_paiement');
            $table->decimal('montant', 10, 2);
            $table->enum('mode_paiement', ['espèces', 'virement', 'mobile_money', 'chèque'])->default('espèces');
            $table->string('reference_transaction', 100)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Secrétaire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
