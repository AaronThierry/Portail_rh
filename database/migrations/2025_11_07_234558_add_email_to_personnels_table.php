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
        Schema::table('personnels', function (Blueprint $table) {
            // Ajouter le champ email après le champ adresse
            $table->string('email', 255)->nullable()->unique()->after('adresse');

            // Ajouter un index pour améliorer les performances
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnels', function (Blueprint $table) {
            // Supprimer l'index et la colonne
            $table->dropIndex(['email']);
            $table->dropColumn('email');
        });
    }
};
