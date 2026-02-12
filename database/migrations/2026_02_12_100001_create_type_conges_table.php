<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('type_conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->string('nom');
            $table->string('code', 20);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('jours_par_an')->default(0);
            $table->string('couleur', 7)->default('#3b7dd8');
            $table->string('icone', 30)->default('calendar');
            $table->boolean('deductible')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['entreprise_id', 'code'], 'unique_type_conge_par_entreprise');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('type_conges');
    }
};
