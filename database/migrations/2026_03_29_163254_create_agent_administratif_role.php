<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::firstOrCreate(
            ['name' => 'Agent administratif'],
            ['guard_name' => 'web']
        );

        $permissions = [
            'view-dashboard', 'view-analytics',
            'view-users', 'view-user-details', 'create-users', 'edit-users', 'export-users',
            'view-departements', 'view-departement-details',
            'view-services', 'view-service-details',
            'view-conges', 'create-conges', 'edit-conges',
            'approve-conges', 'reject-conges', 'manage-conges',
            'view-paies', 'create-paies', 'edit-paies', 'export-paies', 'manage-paies',
            'view-documents', 'upload-documents', 'edit-documents',
            'delete-documents', 'download-documents', 'manage-documents',
            'view-reports', 'create-reports', 'export-reports',
        ];

        $existing = Permission::whereIn('name', $permissions)->pluck('name')->toArray();
        $role->syncPermissions($existing);
    }

    public function down(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::where('name', 'Agent administratif')->first();
        if ($role) {
            $role->syncPermissions([]);
            $role->delete();
        }
    }
};
