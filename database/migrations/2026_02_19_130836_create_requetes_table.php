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
        Schema::create('requetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('sujet', 150);
            $table->enum('categorie', ['question', 'facturation', 'support', 'autre'])->default('question');
            $table->enum('priorite', ['normale', 'urgente'])->default('normale');
            $table->text('message');
            $table->enum('statut', ['en_attente', 'en_cours', 'repondue', 'fermee'])->default('en_attente');
            $table->text('reponse')->nullable();
            $table->foreignId('repondu_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('repondu_le')->nullable();
            $table->boolean('lu_par_admin')->default(false);
            $table->boolean('lu_par_chef')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requetes');
    }
};
