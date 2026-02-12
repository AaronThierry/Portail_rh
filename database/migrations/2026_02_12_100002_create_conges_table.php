<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->foreignId('type_conge_id')->constrained('type_conges')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedSmallInteger('nombre_jours');
            $table->boolean('demi_journee_debut')->default(false);
            $table->boolean('demi_journee_fin')->default(false);

            $table->text('motif')->nullable();
            $table->string('piece_jointe')->nullable();

            $table->enum('statut', ['en_attente', 'approuve', 'refuse', 'annule'])->default('en_attente');
            $table->foreignId('traite_par')->nullable()->constrained('users')->onDelete('set null');
            $table->text('motif_refus')->nullable();
            $table->text('commentaire_admin')->nullable();
            $table->timestamp('traite_at')->nullable();

            $table->unsignedSmallInteger('annee');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['entreprise_id', 'statut']);
            $table->index(['personnel_id', 'annee']);
            $table->index(['personnel_id', 'statut']);
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
