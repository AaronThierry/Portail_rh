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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('entreprise_id')->constrained()->onDelete('cascade');
            $table->foreignId('departement_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->unique()->constrained()->onDelete('set null');

            // Informations personnelles
            $table->string('matricule', 50)->unique();
            $table->string('nom', 100);
            $table->string('prenoms', 150);
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->enum('civilite', ['M.', 'Mme', 'Mlle', 'Dr', 'Pr'])->nullable();

            // Coordonnées
            $table->text('adresse')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('telephone_code_pays', 10)->default('+226'); // Burkina Faso par défaut
            $table->boolean('telephone_whatsapp')->default(true); // Tous les numéros sont WhatsApp par défaut

            // Documents
            $table->string('numero_identification', 100)->nullable()->unique();

            // Poste et contrat
            $table->string('poste', 150)->nullable();
            $table->date('date_naissance')->nullable();
            $table->enum('type_contrat', ['CDI', 'CDD'])->default('CDI');
            $table->date('date_embauche')->nullable();
            $table->date('date_fin_contrat')->nullable();

            // Photo
            $table->string('photo')->nullable();

            // Statut
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Index pour performance
            $table->index(['entreprise_id', 'is_active']);
            $table->index('matricule');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
