<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

/**
 * Seeder pour la création des rôles et permissions du système
 *
 * Ce seeder définit une structure hiérarchique de rôles :
 * - Super Admin : Accès total au système (multi-entreprises)
 * - Admin : Gestion complète d'une entreprise
 * - Manager : Gestion d'équipe et validation
 * - RH : Gestion des ressources humaines
 * - Employé : Accès de base aux fonctionnalités
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Définition de toutes les permissions du système
     * Organisées par modules pour une meilleure lisibilité
     */
    private function getPermissionsStructure(): array
    {
        return [
            'users' => [
                'view-users' => 'Voir la liste des utilisateurs',
                'view-user-details' => 'Voir les détails d\'un utilisateur',
                'create-users' => 'Créer un nouvel utilisateur',
                'edit-users' => 'Modifier un utilisateur existant',
                'delete-users' => 'Supprimer un utilisateur',
                'manage-users' => 'Gestion complète des utilisateurs',
                'export-users' => 'Exporter la liste des utilisateurs',
                'import-users' => 'Importer des utilisateurs',
            ],

            'entreprises' => [
                'view-entreprises' => 'Voir toutes les entreprises',
                'view-entreprise-details' => 'Voir les détails d\'une entreprise',
                'create-entreprises' => 'Créer une nouvelle entreprise',
                'edit-entreprises' => 'Modifier une entreprise',
                'delete-entreprises' => 'Supprimer une entreprise',
                'manage-entreprises' => 'Gestion complète des entreprises',
            ],

            'departements' => [
                'view-departements' => 'Voir les départements',
                'view-departement-details' => 'Voir les détails d\'un département',
                'create-departements' => 'Créer un département',
                'edit-departements' => 'Modifier un département',
                'delete-departements' => 'Supprimer un département',
                'manage-departements' => 'Gestion complète des départements',
            ],

            'services' => [
                'view-services' => 'Voir les services',
                'view-service-details' => 'Voir les détails d\'un service',
                'create-services' => 'Créer un service',
                'edit-services' => 'Modifier un service',
                'delete-services' => 'Supprimer un service',
                'manage-services' => 'Gestion complète des services',
            ],

            'roles' => [
                'view-roles' => 'Voir les rôles',
                'view-role-details' => 'Voir les détails d\'un rôle',
                'create-roles' => 'Créer un rôle',
                'edit-roles' => 'Modifier un rôle',
                'delete-roles' => 'Supprimer un rôle',
                'assign-roles' => 'Attribuer des rôles aux utilisateurs',
                'manage-permissions' => 'Gérer les permissions',
            ],

            'settings' => [
                'view-settings' => 'Voir les paramètres',
                'edit-settings' => 'Modifier les paramètres',
                'manage-settings' => 'Gestion complète des paramètres',
            ],

            'reports' => [
                'view-reports' => 'Voir les rapports',
                'create-reports' => 'Créer des rapports',
                'export-reports' => 'Exporter des rapports',
                'delete-reports' => 'Supprimer des rapports',
            ],

            'dashboard' => [
                'view-dashboard' => 'Accéder au tableau de bord',
                'view-analytics' => 'Voir les statistiques avancées',
                'view-global-stats' => 'Voir les statistiques globales',
            ],

            'conges' => [
                'view-conges' => 'Voir les congés',
                'create-conges' => 'Créer une demande de congé',
                'edit-conges' => 'Modifier une demande de congé',
                'delete-conges' => 'Supprimer une demande de congé',
                'approve-conges' => 'Approuver des congés',
                'reject-conges' => 'Rejeter des congés',
                'manage-conges' => 'Gestion complète des congés',
            ],

            'paies' => [
                'view-paies' => 'Voir les fiches de paie',
                'create-paies' => 'Créer des fiches de paie',
                'edit-paies' => 'Modifier des fiches de paie',
                'delete-paies' => 'Supprimer des fiches de paie',
                'export-paies' => 'Exporter des fiches de paie',
                'manage-paies' => 'Gestion complète des paies',
            ],

            'documents' => [
                'view-documents' => 'Voir les documents',
                'upload-documents' => 'Télécharger des documents',
                'edit-documents' => 'Modifier des documents',
                'delete-documents' => 'Supprimer des documents',
                'download-documents' => 'Télécharger des documents',
                'manage-documents' => 'Gestion complète des documents',
            ],
        ];
    }

    /**
     * Exécute le seeder
     */
    public function run(): void
    {
        // Réinitialise le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('🚀 Démarrage de la création des rôles et permissions...');

        // ========================================
        // CRÉATION DES PERMISSIONS
        // ========================================

        DB::beginTransaction();

        try {
            $permissionsStructure = $this->getPermissionsStructure();
            $allPermissionsCreated = [];

            $this->command->info('📝 Création des permissions par module...');

            foreach ($permissionsStructure as $module => $permissions) {
                $this->command->info("   → Module: {$module}");

                foreach ($permissions as $permissionName => $description) {
                    $permission = Permission::firstOrCreate(
                        ['name' => $permissionName],
                        ['guard_name' => 'web']
                    );
                    $allPermissionsCreated[] = $permission;
                }
            }

            $this->command->info('✅ ' . count($allPermissionsCreated) . ' permissions créées avec succès!');

            $this->command->info('');
            $this->command->info('👥 Création des rôles et attribution des permissions...');

            // ========================================
            // RÔLE 1: SUPER ADMIN
            // ========================================
            $superAdmin = Role::firstOrCreate(['name' => 'Super Admin'], ['guard_name' => 'web']);
            $superAdmin->syncPermissions(Permission::all());
            $this->command->info('   ✓ Super Admin créé avec ' . Permission::count() . ' permissions');

            // ========================================
            // RÔLE 2: ADMIN
            // ========================================
            $admin = Role::firstOrCreate(['name' => 'Admin'], ['guard_name' => 'web']);
            $adminPermissions = [
                // Utilisateurs - Gestion complète
                'view-users', 'view-user-details', 'create-users', 'edit-users', 'delete-users',
                'manage-users', 'export-users', 'import-users',

                // Départements - Gestion complète
                'view-departements', 'view-departement-details', 'create-departements',
                'edit-departements', 'delete-departements', 'manage-departements',

                // Services - Gestion complète
                'view-services', 'view-service-details', 'create-services',
                'edit-services', 'delete-services', 'manage-services',

                // Rôles - Consultation et attribution
                'view-roles', 'view-role-details', 'assign-roles', 'edit-roles',

                // Paramètres
                'view-settings', 'edit-settings', 'manage-settings',

                // Rapports
                'view-reports', 'create-reports', 'export-reports', 'delete-reports',

                // Dashboard
                'view-dashboard', 'view-analytics', 'view-global-stats',

                // Congés - Gestion complète
                'view-conges', 'create-conges', 'edit-conges', 'delete-conges',
                'approve-conges', 'reject-conges', 'manage-conges',

                // Paies - Gestion complète
                'view-paies', 'create-paies', 'edit-paies', 'delete-paies',
                'export-paies', 'manage-paies',

                // Documents - Gestion complète
                'view-documents', 'upload-documents', 'edit-documents',
                'delete-documents', 'download-documents', 'manage-documents',
            ];
            $admin->syncPermissions($adminPermissions);
            $this->command->info('   ✓ Admin créé avec ' . count($adminPermissions) . ' permissions');

            // ========================================
            // RÔLE 3: RH (Ressources Humaines)
            // ========================================
            $rh = Role::firstOrCreate(['name' => 'RH'], ['guard_name' => 'web']);
            $rhPermissions = [
                // Utilisateurs
                'view-users', 'view-user-details', 'create-users', 'edit-users', 'export-users',

                // Départements et Services
                'view-departements', 'view-departement-details',
                'view-services', 'view-service-details',

                // Congés - Gestion complète
                'view-conges', 'create-conges', 'edit-conges', 'approve-conges',
                'reject-conges', 'manage-conges',

                // Paies - Gestion complète
                'view-paies', 'create-paies', 'edit-paies', 'export-paies', 'manage-paies',

                // Documents
                'view-documents', 'upload-documents', 'edit-documents',
                'download-documents', 'manage-documents',

                // Rapports
                'view-reports', 'create-reports', 'export-reports',

                // Dashboard
                'view-dashboard', 'view-analytics',
            ];
            $rh->syncPermissions($rhPermissions);
            $this->command->info('   ✓ RH créé avec ' . count($rhPermissions) . ' permissions');

            // ========================================
            // RÔLE 4: MANAGER
            // ========================================
            $manager = Role::firstOrCreate(['name' => 'Manager'], ['guard_name' => 'web']);
            $managerPermissions = [
                // Utilisateurs - Consultation et modification limitée
                'view-users', 'view-user-details', 'edit-users',

                // Départements et Services
                'view-departements', 'view-departement-details',
                'view-services', 'view-service-details',

                // Congés - Peut approuver/rejeter
                'view-conges', 'approve-conges', 'reject-conges',

                // Rapports
                'view-reports', 'create-reports', 'export-reports',

                // Dashboard
                'view-dashboard', 'view-analytics',

                // Documents
                'view-documents', 'upload-documents', 'download-documents',
            ];
            $manager->syncPermissions($managerPermissions);
            $this->command->info('   ✓ Manager créé avec ' . count($managerPermissions) . ' permissions');

            // ========================================
            // RÔLE 5: EMPLOYÉ
            // ========================================
            $employe = Role::firstOrCreate(['name' => 'Employé'], ['guard_name' => 'web']);
            $employePermissions = [
                // Utilisateurs - Consultation uniquement
                'view-users', 'view-user-details',

                // Structure organisationnelle
                'view-departements', 'view-services',

                // Congés - Créer ses propres demandes
                'view-conges', 'create-conges', 'edit-conges',

                // Paies - Voir ses propres fiches
                'view-paies',

                // Documents - Consultation et téléchargement
                'view-documents', 'download-documents',

                // Rapports - Consultation uniquement
                'view-reports',

                // Dashboard de base
                'view-dashboard',
            ];
            $employe->syncPermissions($employePermissions);
            $this->command->info('   ✓ Employé créé avec ' . count($employePermissions) . ' permissions');

            // ========================================
            // RÔLE 6: CHEF D'ENTREPRISE
            // ========================================
            $chefEntreprise = Role::firstOrCreate(['name' => "Chef d'Entreprise"], ['guard_name' => 'web']);
            $chefEntreprisePermissions = [
                // Dashboard — accès à son tableau de bord uniquement
                'view-dashboard', 'view-analytics',

                // Personnel — consultation uniquement
                'view-users', 'view-user-details',

                // Congés — consultation uniquement
                'view-conges',

                // Paies — consultation uniquement
                'view-paies',

                // Documents — consultation et téléchargement
                'view-documents', 'download-documents',

                // Rapports — consultation uniquement
                'view-reports',
            ];
            $chefEntreprise->syncPermissions($chefEntreprisePermissions);
            $this->command->info("   ✓ Chef d'Entreprise créé avec " . count($chefEntreprisePermissions) . ' permissions (lecture seule)');

            DB::commit();

            // ========================================
            // MESSAGES DE CONFIRMATION
            // ========================================
            $this->command->info('');
            $this->command->line('══════════════════════════════════════════════════════════');
            $this->command->info('✅ Rôles et permissions créés avec succès!');
            $this->command->line('══════════════════════════════════════════════════════════');
            $this->command->info('📊 Total des permissions: ' . Permission::count());
            $this->command->info("👥 Rôles créés: Super Admin, Admin, RH, Manager, Employé, Chef d'Entreprise");
            $this->command->line('══════════════════════════════════════════════════════════');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Erreur lors de la création: ' . $e->getMessage());
            throw $e;
        }
    }
}
