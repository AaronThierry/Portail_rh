<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Helpers\PermissionHelper;

/**
 * Commande Artisan pour gérer les permissions et rôles
 *
 * Usage:
 *   php artisan permission:manage
 */
class PermissionManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:manage
                            {action? : Action à effectuer (list, assign, test, sync)}
                            {--user= : ID de l\'utilisateur pour assign}
                            {--role= : Nom du rôle pour assign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gestionnaire de permissions et rôles du système';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        if (!$action) {
            return $this->showMenu();
        }

        switch ($action) {
            case 'list':
                return $this->listPermissions();
            case 'assign':
                return $this->assignRole();
            case 'test':
                return $this->testPermissions();
            case 'sync':
                return $this->syncPermissions();
            default:
                $this->error("Action invalide: {$action}");
                return 1;
        }
    }

    /**
     * Affiche le menu interactif
     */
    protected function showMenu()
    {
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║      GESTIONNAIRE DE PERMISSIONS ET RÔLES                   ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();

        $choice = $this->choice(
            'Que voulez-vous faire ?',
            [
                'list' => 'Lister toutes les permissions et rôles',
                'assign' => 'Attribuer un rôle à un utilisateur',
                'test' => 'Tester les permissions d\'un utilisateur',
                'sync' => 'Synchroniser permissions et rôles (seeder)',
                'exit' => 'Quitter',
            ],
            'list'
        );

        if ($choice === 'exit') {
            $this->info('Au revoir !');
            return 0;
        }

        // Exécuter l'action choisie
        switch ($choice) {
            case 'list':
                return $this->listPermissions();
            case 'assign':
                return $this->assignRole();
            case 'test':
                return $this->testPermissions();
            case 'sync':
                return $this->syncPermissions();
            default:
                $this->error("Action invalide: {$choice}");
                return 1;
        }
    }

    /**
     * Liste toutes les permissions et rôles
     */
    protected function listPermissions()
    {
        $this->info('📊 STATISTIQUES GÉNÉRALES');
        $this->line('══════════════════════════════════════════════════════════════');
        $this->table(
            ['Élément', 'Nombre'],
            [
                ['Permissions', Permission::count()],
                ['Rôles', Role::count()],
                ['Utilisateurs', User::count()],
                ['Utilisateurs avec rôles', User::has('roles')->count()],
            ]
        );

        $this->newLine();
        $this->info('👥 RÔLES ET LEURS PERMISSIONS');
        $this->line('══════════════════════════════════════════════════════════════');

        $roles = Role::with('permissions')->get();
        $roleData = [];

        foreach ($roles as $role) {
            $roleData[] = [
                $role->name,
                $role->permissions->count(),
                $role->users()->count(),
            ];
        }

        $this->table(
            ['Rôle', 'Permissions', 'Utilisateurs'],
            $roleData
        );

        return 0;
    }

    /**
     * Attribue un rôle à un utilisateur
     */
    protected function assignRole()
    {
        $userId = $this->option('user');
        $roleName = $this->option('role');

        // Sélection interactive si options non fournies
        if (!$userId) {
            $users = User::all();
            $userChoices = [];

            foreach ($users as $user) {
                $userChoices[$user->id] = "{$user->name} ({$user->email})";
            }

            $userId = $this->choice('Sélectionnez un utilisateur', $userChoices);
        }

        $user = User::find($userId);

        if (!$user) {
            $this->error("Utilisateur #{$userId} introuvable.");
            return 1;
        }

        if (!$roleName) {
            $roles = Role::all()->pluck('name')->toArray();
            $roleName = $this->choice('Sélectionnez un rôle', $roles);
        }

        $role = Role::findByName($roleName);

        if (!$role) {
            $this->error("Rôle '{$roleName}' introuvable.");
            return 1;
        }

        // Affiche les rôles actuels
        $currentRoles = $user->roles->pluck('name')->toArray();
        if (!empty($currentRoles)) {
            $this->warn("Rôles actuels: " . implode(', ', $currentRoles));
        }

        // Demande confirmation
        if ($this->confirm("Attribuer le rôle '{$roleName}' à {$user->name} ?", true)) {
            $user->assignRole($roleName);
            PermissionHelper::clearPermissionCache();

            $this->info("✅ Rôle '{$roleName}' attribué avec succès à {$user->name}");
            $this->info("✅ L'utilisateur a maintenant " . $user->getAllPermissions()->count() . " permissions");
        } else {
            $this->info('Opération annulée.');
        }

        return 0;
    }

    /**
     * Teste les permissions d'un utilisateur
     */
    protected function testPermissions()
    {
        $users = User::all();
        $userChoices = [];

        foreach ($users as $user) {
            $userChoices[$user->id] = "{$user->name} ({$user->email})";
        }

        $userId = $this->choice('Sélectionnez un utilisateur', $userChoices);
        $user = User::find($userId);

        if (!$user) {
            $this->error("Utilisateur introuvable.");
            return 1;
        }

        $this->info("👤 Test des permissions pour: {$user->name}");
        $this->line('══════════════════════════════════════════════════════════════');

        // Rôles
        $roles = $user->roles->pluck('name')->toArray();
        $this->info("Rôle(s): " . (empty($roles) ? 'Aucun' : implode(', ', $roles)));

        // Permissions totales
        $allPermissions = $user->getAllPermissions();
        $this->info("Permissions totales: {$allPermissions->count()}");

        $this->newLine();

        // Test de permissions clés
        $testPermissions = [
            'view-users' => 'Voir les utilisateurs',
            'create-users' => 'Créer des utilisateurs',
            'delete-users' => 'Supprimer des utilisateurs',
            'view-entreprises' => 'Voir les entreprises',
            'manage-permissions' => 'Gérer les permissions',
            'view-dashboard' => 'Accéder au dashboard',
        ];

        $resultsData = [];

        foreach ($testPermissions as $perm => $desc) {
            $has = $user->hasPermissionTo($perm);
            $resultsData[] = [
                $perm,
                $desc,
                $has ? '✅ Oui' : '❌ Non',
            ];
        }

        $this->table(
            ['Permission', 'Description', 'Autorisé'],
            $resultsData
        );

        return 0;
    }

    /**
     * Synchronise les permissions (lance le seeder)
     */
    protected function syncPermissions()
    {
        if ($this->confirm('Cette action va resynchroniser tous les rôles et permissions. Continuer ?', true)) {
            $this->info('🔄 Synchronisation en cours...');

            $this->call('db:seed', [
                '--class' => 'RolesAndPermissionsSeeder'
            ]);

            $this->info('✅ Synchronisation terminée !');
        } else {
            $this->info('Opération annulée.');
        }

        return 0;
    }
}
