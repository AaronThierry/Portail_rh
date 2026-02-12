<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('type_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->string('nom');
            $table->string('code')->index();
            $table->text('description')->nullable();
            $table->string('couleur', 10)->default('#6b7280');
            $table->string('icone', 50)->default('alert-circle');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['entreprise_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('type_absences');
    }
};
