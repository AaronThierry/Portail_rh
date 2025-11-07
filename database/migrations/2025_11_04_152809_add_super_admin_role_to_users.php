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
        // MySQL ne permet pas de modifier directement un ENUM
        // On doit utiliser une requête SQL brute
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'manager', 'employee', 'hr') DEFAULT 'employee'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'employee', 'hr') DEFAULT 'employee'");
    }
};
