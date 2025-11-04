<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ajoute les colonnes nécessaires pour la réinitialisation de mot de passe
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Colonne pour stocker le code de réinitialisation hashé
            $table->string('password_reset_code')->nullable()->after('password');

            // Colonne pour stocker la date d'expiration du code (1 heure)
            $table->timestamp('password_reset_expires_at')->nullable()->after('password_reset_code');
        });
    }

    /**
     * Reverse the migrations.
     * Supprime les colonnes de réinitialisation de mot de passe
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Suppression des colonnes si on annule la migration
            $table->dropColumn(['password_reset_code', 'password_reset_expires_at']);
        });
    }
};
