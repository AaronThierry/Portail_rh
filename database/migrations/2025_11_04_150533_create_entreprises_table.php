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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('sigle')->nullable();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->default('Cameroun');
            $table->string('code_postal')->nullable();
            $table->string('site_web')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('secteur_activite')->nullable();
            $table->integer('nombre_employes')->nullable();
            $table->string('numero_registre')->nullable();
            $table->string('numero_fiscal')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
