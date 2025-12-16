<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Réinitialiser le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Liste complète des permissions par catégorie
        $permissions = [
            // Gestion des Utilisateurs
            'users' => [
                'view-users' => 'Consulter la liste des utilisateurs',
                'create-users' => 'Créer de nouveaux utilisateurs',
                'edit-users' => 'Modifier les informations des utilisateurs',
                'delete-users' => 'Supprimer des utilisateurs',
            ],

            // Gestion des Rôles
            'roles' => [
                'view-roles' => 'Consulter la liste des rôles',
                'create-roles' => 'Créer de nouveaux rôles',
                'edit-roles' => 'Modifier les rôles existants',
                'delete-roles' => 'Supprimer des rôles',
                'assign-roles' => 'Assigner des rôles aux utilisateurs',
            ],

            // Gestion des Permissions
            'permissions' => [
                'view-permissions' => 'Consulter la liste des permissions',
                'create-permissions' => 'Créer de nouvelles permissions',
                'edit-permissions' => 'Modifier les permissions existantes',
                'delete-permissions' => 'Supprimer des permissions',
                'manage-permissions' => 'Gérer l\'attribution des permissions aux rôles',
            ],

            // Gestion des Entreprises
            'entreprises' => [
                'view-entreprises' => 'Consulter la liste des entreprises',
                'create-entreprises' => 'Créer de nouvelles entreprises',
                'edit-entreprises' => 'Modifier les entreprises',
                'delete-entreprises' => 'Supprimer des entreprises',
            ],

            // Gestion des Départements
            'departements' => [
                'view-departements' => 'Consulter la liste des départements',
                'create-departements' => 'Créer de nouveaux départements',
                'edit-departements' => 'Modifier les départements',
                'delete-departements' => 'Supprimer des départements',
            ],

            // Gestion des Services
            'services' => [
                'view-services' => 'Consulter la liste des services',
                'create-services' => 'Créer de nouveaux services',
                'edit-services' => 'Modifier les services',
                'delete-services' => 'Supprimer des services',
            ],

            // Gestion des Documents
            'documents' => [
                'view-documents' => 'Consulter les documents',
                'create-documents' => 'Créer/uploader de nouveaux documents',
                'edit-documents' => 'Modifier les documents',
                'delete-documents' => 'Supprimer des documents',
                'download-documents' => 'Télécharger les documents',
            ],

            // Gestion des Dossiers Agents
            'dossiers-agents' => [
                'view-dossiers-agents' => 'Consulter les dossiers agents',
                'create-dossiers-agents' => 'Ajouter des documents aux dossiers agents',
                'edit-dossiers-agents' => 'Modifier les documents des dossiers agents',
                'delete-dossiers-agents' => 'Supprimer des documents des dossiers agents',
                'download-dossiers-agents' => 'Télécharger les documents des dossiers agents',
                'manage-categories-dossiers' => 'Gérer les catégories de documents',
            ],

            // Gestion des Demandes
            'demandes' => [
                'view-demandes' => 'Consulter les demandes',
                'create-demandes' => 'Créer de nouvelles demandes',
                'edit-demandes' => 'Modifier les demandes',
                'delete-demandes' => 'Supprimer des demandes',
                'approve-demandes' => 'Approuver/Rejeter les demandes',
            ],

            // Gestion des Congés
            'conges' => [
                'view-conges' => 'Consulter les demandes de congés',
                'create-conges' => 'Créer des demandes de congés',
                'edit-conges' => 'Modifier les demandes de congés',
                'delete-conges' => 'Supprimer des demandes de congés',
                'approve-conges' => 'Approuver/Rejeter les congés',
            ],

            // Gestion de la Paie
            'paie' => [
                'view-paie' => 'Consulter les informations de paie',
                'create-paie' => 'Créer des bulletins de paie',
                'edit-paie' => 'Modifier les informations de paie',
                'delete-paie' => 'Supprimer des données de paie',
                'export-paie' => 'Exporter les données de paie',
            ],

            // Gestion des Rapports
            'rapports' => [
                'view-rapports' => 'Consulter les rapports',
                'create-rapports' => 'Créer de nouveaux rapports',
                'export-rapports' => 'Exporter les rapports',
            ],

            // Paramètres Système
            'settings' => [
                'view-settings' => 'Consulter les paramètres système',
                'edit-settings' => 'Modifier les paramètres système',
            ],
        ];

        $this->command->info('🔐 Création des permissions...');

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($permissions as $category => $categoryPermissions) {
            $this->command->info("📂 Catégorie : " . ucfirst($category));

            foreach ($categoryPermissions as $permissionName => $description) {
                // Vérifier si la permission existe déjà
                $existing = Permission::where('name', $permissionName)->first();

                if (!$existing) {
                    Permission::create([
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ]);
                    $this->command->info("  ✅ {$permissionName} créée");
                    $createdCount++;
                } else {
                    $this->command->warn("  ⚠️  {$permissionName} existe déjà");
                    $skippedCount++;
                }
            }
        }

        $this->command->info("\n📊 Résumé :");
        $this->command->info("  ✅ Permissions créées : {$createdCount}");
        $this->command->info("  ⚠️  Permissions ignorées (déjà existantes) : {$skippedCount}");

        // Attribution des permissions aux rôles
        $this->assignPermissionsToRoles();
    }

    /**
     * Attribue automatiquement les permissions aux rôles
     */
    private function assignPermissionsToRoles(): void
    {
        $this->command->info("\n🎭 Attribution des permissions aux rôles...");

        // Super Admin : TOUTES les permissions
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
            $this->command->info("  ✅ Super Admin : TOUTES les permissions (" . Permission::count() . ")");
        }

        // Admin : Presque toutes les permissions sauf système critique
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $adminPermissions = Permission::where('name', 'not like', '%settings%')->get();
            $admin->syncPermissions($adminPermissions);
            $this->command->info("  ✅ Admin : {$adminPermissions->count()} permissions");
        }

        // Manager : Permissions de gestion basique
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $managerPermissions = Permission::whereIn('name', [
            'view-users', 'edit-users',
            'view-departements', 'view-services',
            'view-documents', 'create-documents',
            'view-demandes', 'create-demandes', 'approve-demandes',
            'view-conges', 'approve-conges',
            'view-rapports',
            'view-dossiers-agents', 'create-dossiers-agents', 'download-dossiers-agents',
        ])->get();
        $manager->syncPermissions($managerPermissions);
        $this->command->info("  ✅ Manager : {$managerPermissions->count()} permissions");

        // RH : Permissions RH complètes
        $rh = Role::firstOrCreate(['name' => 'RH', 'guard_name' => 'web']);
        $rhPermissions = Permission::whereIn('name', [
            'view-users', 'edit-users', 'create-users',
            'view-departements', 'view-services',
            'view-documents', 'create-documents', 'edit-documents', 'delete-documents', 'download-documents',
            'view-demandes', 'create-demandes', 'approve-demandes',
            'view-conges', 'approve-conges',
            'view-rapports', 'export-rapports',
            'view-dossiers-agents', 'create-dossiers-agents', 'edit-dossiers-agents', 'delete-dossiers-agents', 'download-dossiers-agents', 'manage-categories-dossiers',
        ])->get();
        $rh->syncPermissions($rhPermissions);
        $this->command->info("  ✅ RH : {$rhPermissions->count()} permissions");

        // Employé : Permissions de base
        $employe = Role::firstOrCreate(['name' => 'Employé', 'guard_name' => 'web']);
        $employePermissions = Permission::whereIn('name', [
            'view-users',
            'view-documents',
            'view-demandes', 'create-demandes',
            'view-conges', 'create-conges',
        ])->get();
        $employe->syncPermissions($employePermissions);
        $this->command->info("  ✅ Employé : {$employePermissions->count()} permissions");

        $this->command->info("\n✨ Attribution des permissions terminée !");
    }
}
