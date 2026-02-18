<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conges', function (Blueprint $table) {
            $table->unsignedBigInteger('valide_chef_par')->nullable()->after('traite_at');
            $table->timestamp('valide_chef_at')->nullable()->after('valide_chef_par');

            $table->foreign('valide_chef_par')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('absences', function (Blueprint $table) {
            $table->unsignedBigInteger('valide_chef_par')->nullable()->after('traite_at');
            $table->timestamp('valide_chef_at')->nullable()->after('valide_chef_par');

            $table->foreign('valide_chef_par')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('conges', function (Blueprint $table) {
            $table->dropForeign(['valide_chef_par']);
            $table->dropColumn(['valide_chef_par', 'valide_chef_at']);
        });

        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign(['valide_chef_par']);
            $table->dropColumn(['valide_chef_par', 'valide_chef_at']);
        });
    }
};
