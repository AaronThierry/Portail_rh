<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulletin_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->string('fichier_zip');
            $table->string('periode', 7)->nullable()->comment('Format YYYY-MM');
            $table->unsignedSmallInteger('total')->default(0);
            $table->unsignedSmallInteger('succes')->default(0);
            $table->unsignedSmallInteger('doublons')->default(0);
            $table->unsignedSmallInteger('erreurs_count')->default(0);
            $table->json('erreurs')->nullable()->comment('Liste des erreurs [{fichier, raison}]');
            $table->json('bulletins_crees')->nullable()->comment('IDs des bulletins créés');
            $table->enum('statut', ['en_cours', 'termine', 'partiel', 'echec'])->default('en_cours');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletin_imports');
    }
};
