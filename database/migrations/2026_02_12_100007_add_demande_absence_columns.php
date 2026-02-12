<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->enum('source', ['admin', 'employe'])->default('admin')->after('justifiee');
            $table->enum('statut', ['en_attente', 'approuvee', 'refusee'])->default('approuvee')->after('source');
            $table->text('motif_refus')->nullable()->after('statut');
            $table->foreignId('traite_par')->nullable()->constrained('users')->onDelete('set null')->after('motif_refus');
            $table->timestamp('traite_at')->nullable()->after('traite_par');
        });
    }

    public function down(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign(['traite_par']);
            $table->dropColumn(['source', 'statut', 'motif_refus', 'traite_par', 'traite_at']);
        });
    }
};
