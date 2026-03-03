<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Supprime les contraintes UNIQUE MySQL sur les colonnes soft-deletable.
 *
 * Problème : quand un personnel est soft-deleted, son matricule/email/numero
 * occupe toujours le slot de la contrainte UNIQUE MySQL. Si on tente d'insérer
 * un nouveau personnel avec le même matricule (cas légitime), MySQL rejette
 * l'insert même si Laravel valide via Rule::unique()->whereNull('deleted_at').
 *
 * Solution : déléguer l'unicité à Laravel (FormRequests) et garder des index
 * simples pour les performances.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Supprimer les contraintes UNIQUE sur les colonnes soft-deletable.
        // On passe par SHOW INDEX pour ne pas échouer si le nom diffère.
        foreach (['matricule', 'email', 'numero_identification'] as $column) {
            $this->dropUniqueOnColumn('personnels', $column);
        }

        // Ajouter des index simples pour les perfs (si pas déjà présents)
        Schema::table('personnels', function (Blueprint $table) {
            foreach ([
                'matricule'             => 'personnels_matricule_index',
                'email'                 => 'personnels_email_index',
                'numero_identification' => 'personnels_numero_identification_index',
            ] as $column => $indexName) {
                if (!$this->indexExists('personnels', $indexName)) {
                    $table->index($column, $indexName);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('personnels', function (Blueprint $table) {
            // Retirer les index simples s'ils existent
            foreach ([
                'personnels_matricule_index',
                'personnels_email_index',
                'personnels_numero_identification_index',
            ] as $idx) {
                if ($this->indexExists('personnels', $idx)) {
                    $table->dropIndex($idx);
                }
            }

            // Restaurer les contraintes uniques si elles n'existent pas
            foreach ([
                'matricule'             => 'personnels_matricule_unique',
                'email'                 => 'personnels_email_unique',
                'numero_identification' => 'personnels_numero_identification_unique',
            ] as $column => $uniqueName) {
                if (!$this->indexExists('personnels', $uniqueName)) {
                    $table->unique($column, $uniqueName);
                }
            }
        });
    }

    /**
     * Supprime TOUS les index UNIQUE portant sur une colonne donnée,
     * quel que soit leur nom exact dans le moteur.
     */
    private function dropUniqueOnColumn(string $table, string $column): void
    {
        $indexes = DB::select(
            "SHOW INDEX FROM `{$table}` WHERE Column_name = ? AND Non_unique = 0 AND Key_name != 'PRIMARY'",
            [$column]
        );

        foreach ($indexes as $index) {
            DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$index->Key_name}`");
        }
    }

    /**
     * Vérifie si un index existe par son nom exact.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        return !empty(DB::select(
            "SHOW INDEX FROM `{$table}` WHERE Key_name = ?",
            [$indexName]
        ));
    }
};
