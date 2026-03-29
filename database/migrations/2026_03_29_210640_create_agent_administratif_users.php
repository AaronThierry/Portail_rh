<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Entreprise;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Récupérer la première entreprise disponible
        $entreprise = Entreprise::first();
        $entrepriseId = $entreprise?->id;

        // S'assurer que le rôle existe
        $role = Role::firstOrCreate(
            ['name' => 'Agent administratif'],
            ['guard_name' => 'web']
        );

        $comptes = [
            [
                'email' => 'mounirapare0@gmail.com',
                'name'  => 'Mounira Paré',
            ],
            [
                'email' => 'faycaltraore2000@gmail.com',
                'name'  => 'Faycal Traoré',
            ],
        ];

        foreach ($comptes as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'                  => $data['name'],
                    'entreprise_id'         => $entrepriseId,
                    'password'              => Hash::make('RH@2025!'),
                    'role'                  => 'admin',
                    'status'                => 'active',
                    'force_password_change' => true,
                    'email_verified_at'     => now(),
                ]
            );

            if (!$user->hasRole('Agent administratif')) {
                $user->assignRole($role);
            }
        }
    }

    public function down(): void
    {
        $emails = ['mounirapare0@gmail.com', 'faycaltraore2000@gmail.com'];

        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->syncRoles([]);
                $user->delete();
            }
        }
    }
};
