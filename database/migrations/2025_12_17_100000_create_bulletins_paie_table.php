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
        Schema::create('bulletins_paie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');

            // Période du bulletin
            $table->unsignedSmallInteger('mois'); // 1-12
            $table->unsignedSmallInteger('annee'); // 2024, 2025, etc.
            $table->string('periode')->virtualAs("CONCAT(annee, '-', LPAD(mois, 2, '0'))"); // Format: 2025-01

            // Fichier
            $table->string('fichier_path');
            $table->string('fichier_nom_original');
            $table->string('fichier_type')->default('application/pdf');
            $table->unsignedBigInteger('fichier_taille')->default(0); // en octets

            // Informations du bulletin
            $table->decimal('salaire_brut', 12, 2)->nullable();
            $table->decimal('salaire_net', 12, 2)->nullable();
            $table->string('reference')->nullable(); // Référence unique du bulletin

            // Statut et visibilité
            $table->enum('statut', ['brouillon', 'publie', 'archive'])->default('publie');
            $table->boolean('visible_employe')->default(true);
            $table->boolean('notifier_employe')->default(false);
            $table->timestamp('notifie_at')->nullable();

            // Commentaires et notes
            $table->text('commentaire')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index(['annee', 'mois']);
            $table->index(['personnel_id', 'annee', 'mois']);
            $table->unique(['personnel_id', 'annee', 'mois'], 'unique_bulletin_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulletins_paie');
    }
};
