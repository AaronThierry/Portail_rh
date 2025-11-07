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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->text('value')->nullable();
            $table->string('scope')->default('global')->index(); // 'global' ou 'entreprise_{id}'
            $table->text('description')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->timestamps();

            // Index composite pour optimiser les requêtes
            $table->unique(['key', 'scope']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
