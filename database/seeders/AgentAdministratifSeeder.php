<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AgentAdministratifSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::firstOrCreate(
            ['name' => 'Agent administratif'],
            ['guard_name' => 'web']
        );

        $permissions = [
            // Dashboard
            'view-dashboard', 'view-analytics',

            // Personnel — lecture + création + modification (pas suppression)
            'view-users', 'view-user-details', 'create-users', 'edit-users', 'export-users',

            // Structure organisationnelle — lecture seule
            'view-departements', 'view-departement-details',
            'view-services', 'view-service-details',

            // Congés — gestion complète
            'view-conges', 'create-conges', 'edit-conges',
            'approve-conges', 'reject-conges', 'manage-conges',

            // Paies — gestion complète
            'view-paies', 'create-paies', 'edit-paies', 'export-paies', 'manage-paies',

            // Documents — gestion complète
            'view-documents', 'upload-documents', 'edit-documents',
            'delete-documents', 'download-documents', 'manage-documents',

            // Rapports
            'view-reports', 'create-reports', 'export-reports',
        ];

        // Ne garder que les permissions qui existent réellement en base
        $existingPermissions = Permission::whereIn('name', $permissions)->pluck('name')->toArray();
        $role->syncPermissions($existingPermissions);

        $this->command->info('✅ Rôle "Agent administratif" créé avec ' . count($existingPermissions) . ' permissions.');
        $this->command->info('   Accès : Dashboard, Personnel, Congés, Paies, Documents, Rapports');
        $this->command->info('   Exclus : Administration (Rôles, Permissions, Paramètres, Entreprises)');
    }
}
