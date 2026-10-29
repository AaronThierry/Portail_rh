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
            if (!Schema::hasColumn('users', 'motif_desactivation')) {
                $table->enum('motif_desactivation', ['demission', 'licenciement', 'fin_contrat', 'autre'])
                    ->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'desactive_le')) {
                $table->timestamp('desactive_le')->nullable()->after('motif_desactivation');
            }
            if (!Schema::hasColumn('users', 'desactive_par_id')) {
                $table->foreignId('desactive_par_id')->nullable()->after('desactive_le')
                    ->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'desactive_par_id')) {
                $table->dropConstrainedForeignId('desactive_par_id');
            }
            foreach (['motif_desactivation', 'desactive_le'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
