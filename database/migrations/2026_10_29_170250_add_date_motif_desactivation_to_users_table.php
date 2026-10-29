<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Date effective du motif (ex. dernier jour travaillé pour une démission),
     * distincte de `desactive_le` qui horodate automatiquement l'action de
     * désactivation elle-même — l'admin peut traiter un départ plusieurs
     * jours après sa date réelle.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'date_motif_desactivation')) {
                $table->date('date_motif_desactivation')->nullable()->after('motif_desactivation');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'date_motif_desactivation')) {
                $table->dropColumn('date_motif_desactivation');
            }
        });
    }
};
