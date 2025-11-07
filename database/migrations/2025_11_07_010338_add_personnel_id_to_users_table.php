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
        Schema::table('users', function (Blueprint $table) {
            // Ajouter la colonne personnel_id après entreprise_id
            $table->foreignId('personnel_id')->nullable()->after('entreprise_id')->constrained('personnels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne
            $table->dropForeign(['personnel_id']);
            $table->dropColumn('personnel_id');
        });
    }
};
