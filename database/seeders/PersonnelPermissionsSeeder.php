<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PersonnelPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions pour le module Personnel
        $permissions = [
            'view-personnel' => 'Voir la liste du personnel',
            'create-personnel' => 'Créer un nouveau personnel',
            'edit-personnel' => 'Modifier les informations du personnel',
            'delete-personnel' => 'Supprimer un personnel',
            'export-personnel' => 'Exporter les données du personnel',
            'assign-user-accounts' => 'Assigner des comptes utilisateurs au personnel',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web']
            );
            $this->command->info("Permission créée: {$name}");
        }

        // Assigner les permissions aux rôles existants
        $this->assignPermissionsToRoles();
    }

    /**
     * Assigner les permissions aux rôles
     */
    private function assignPermissionsToRoles()
    {
        // Super Admin - Toutes les permissions
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo([
                'view-personnel',
                'create-personnel',
                'edit-personnel',
                'delete-personnel',
                'export-personnel',
                'assign-user-accounts',
            ]);
            $this->command->info('Permissions assignées à Super Admin');
        }

        // Admin - Toutes les permissions sauf delete
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $admin->givePermissionTo([
                'view-personnel',
                'create-personnel',
                'edit-personnel',
                'export-personnel',
                'assign-user-accounts',
            ]);
            $this->command->info('Permissions assignées à Admin');
        }

        // RH - Toutes les permissions sauf assignation de comptes
        $rh = Role::where('name', 'RH')->first();
        if ($rh) {
            $rh->givePermissionTo([
                'view-personnel',
                'create-personnel',
                'edit-personnel',
                'export-personnel',
            ]);
            $this->command->info('Permissions assignées à RH');
        }

        // Manager - Consultation et export uniquement
        $manager = Role::where('name', 'Manager')->first();
        if ($manager) {
            $manager->givePermissionTo([
                'view-personnel',
                'export-personnel',
            ]);
            $this->command->info('Permissions assignées à Manager');
        }

        // Employé - Consultation seulement (optionnel)
        $employe = Role::where('name', 'Employé')->first();
        if ($employe) {
            $employe->givePermissionTo([
                'view-personnel',
            ]);
            $this->command->info('Permissions assignées à Employé');
        }
    }
}
