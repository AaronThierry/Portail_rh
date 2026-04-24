<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistant_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('fichier_path');
            $table->string('gemini_file_uri')->nullable();
            $table->string('gemini_file_name')->nullable();
            $table->boolean('actif')->default(true);
            $table->foreignId('entreprise_id')->nullable()->constrained()->nullOnDelete();
            $table->bigInteger('taille')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('uri_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_documents');
    }
};
