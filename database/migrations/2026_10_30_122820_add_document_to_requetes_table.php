<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requetes', function (Blueprint $table) {
            if (!Schema::hasColumn('requetes', 'document')) {
                $table->string('document')->nullable()->after('reponse');
            }
        });
    }

    public function down(): void
    {
        Schema::table('requetes', function (Blueprint $table) {
            if (Schema::hasColumn('requetes', 'document')) {
                $table->dropColumn('document');
            }
        });
    }
};
