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
        // Table des catégories de documents
        Schema::create('categories_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('icone')->default('folder');
            $table->string('couleur')->default('#667eea');
            $table->integer('ordre')->default(0);
            $table->boolean('obligatoire')->default(false);
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->unique(['entreprise_id', 'slug']);
        });

        // Table des documents agents
        Schema::create('documents_agent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->foreignId('categorie_id')->nullable()->constrained('categories_documents')->onDelete('set null');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');

            // Informations du fichier
            $table->string('nom_original');
            $table->string('nom_fichier');
            $table->string('chemin');
            $table->string('extension', 10);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('taille'); // en octets

            // Métadonnées
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_document')->nullable();
            $table->date('date_expiration')->nullable();
            $table->string('reference')->nullable();

            // Statut et visibilité
            $table->enum('statut', ['actif', 'archive', 'expire'])->default('actif');
            $table->boolean('confidentiel')->default(false);
            $table->boolean('visible_employe')->default(true);

            // Versioning
            $table->unsignedInteger('version')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('documents_agent')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Index pour recherche rapide
            $table->index(['personnel_id', 'categorie_id']);
            $table->index(['personnel_id', 'statut']);
            $table->index('date_expiration');
        });

        // Table de log des téléchargements
        Schema::create('documents_agent_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents_agent')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('action', ['view', 'download', 'upload', 'update', 'delete', 'restore']);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('details')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_agent_logs');
        Schema::dropIfExists('documents_agent');
        Schema::dropIfExists('categories_documents');
    }
};
