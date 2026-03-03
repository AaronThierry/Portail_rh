<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Supprime les contraintes UNIQUE MySQL sur les colonnes soft-deletable.
 *
 * Problème : quand un personnel est soft-deleted, son matricule/email/numero
 * occupe toujours le slot de la contrainte UNIQUE MySQL. Si on tente d'insérer
 * un nouveau personnel avec le même matricule (cas légitime), MySQL rejette
 * l'insert même si Laravel valide correctement via Rule::unique()->whereNull('deleted_at').
 *
 * Solution : déléguer l'unicité entièrement à Laravel (StorePersonnelRequest +
 * UpdatePersonnelRequest) et ne garder que des index simples pour les perfs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personnels', function (Blueprint $table) {
            // Supprimer les contraintes UNIQUE qui bloquent la réutilisation
            // après soft-delete. Laravel gère l'unicité via Rule::unique()->whereNull('deleted_at').
            $table->dropUnique('personnels_matricule_unique');
            $table->dropUnique('personnels_email_unique');
            $table->dropUnique('personnels_numero_identification_unique');

            // Garder des index simples pour les performances des requêtes
            $table->index('matricule',             'personnels_matricule_index');
            $table->index('email',                 'personnels_email_index');
            $table->index('numero_identification', 'personnels_numero_identification_index');
        });
    }

    public function down(): void
    {
        Schema::table('personnels', function (Blueprint $table) {
            // Restaurer les contraintes uniques
            $table->dropIndex('personnels_matricule_index');
            $table->dropIndex('personnels_email_index');
            $table->dropIndex('personnels_numero_identification_index');

            $table->unique('matricule',             'personnels_matricule_unique');
            $table->unique('email',                 'personnels_email_unique');
            $table->unique('numero_identification', 'personnels_numero_identification_unique');
        });
    }
};
