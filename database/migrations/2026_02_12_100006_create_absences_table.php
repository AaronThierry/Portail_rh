<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->foreignId('type_absence_id')->constrained('type_absences')->onDelete('restrict');
            $table->foreignId('enregistre_par')->constrained('users')->onDelete('cascade');

            $table->date('date_absence');
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->enum('duree_type', ['journee', 'demi_journee', 'retard', 'depart_anticipe'])->default('journee');
            $table->unsignedSmallInteger('minutes_retard')->nullable();

            $table->text('motif')->nullable();
            $table->text('commentaire_admin')->nullable();
            $table->string('justificatif')->nullable();
            $table->boolean('justifiee')->default(false);

            $table->unsignedSmallInteger('annee');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['entreprise_id', 'annee']);
            $table->index(['personnel_id', 'annee']);
            $table->index(['personnel_id', 'date_absence']);
            $table->index('date_absence');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
