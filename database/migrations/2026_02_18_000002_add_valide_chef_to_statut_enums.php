<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter 'valide_chef' à l'ENUM statut de la table conges
        DB::statement("ALTER TABLE conges MODIFY COLUMN statut ENUM('en_attente', 'valide_chef', 'approuve', 'refuse', 'annule') NOT NULL DEFAULT 'en_attente'");

        // Ajouter 'valide_chef' à l'ENUM statut de la table absences
        DB::statement("ALTER TABLE absences MODIFY COLUMN statut ENUM('en_attente', 'valide_chef', 'approuvee', 'refusee') NOT NULL DEFAULT 'approuvee'");
    }

    public function down(): void
    {
        // Retirer 'valide_chef' (les lignes avec ce statut seront tronquées — à éviter en prod)
        DB::statement("ALTER TABLE conges MODIFY COLUMN statut ENUM('en_attente', 'approuve', 'refuse', 'annule') NOT NULL DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE absences MODIFY COLUMN statut ENUM('en_attente', 'approuvee', 'refusee') NOT NULL DEFAULT 'approuvee'");
    }
};
