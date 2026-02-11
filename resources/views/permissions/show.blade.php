@extends('layouts.app')

@section('title', 'Permission - ' . $permission->name)
@section('page-title', 'Details de la Permission')

@section('content')
<div style="padding: 1.5rem;">
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('admin.permissions.index') }}" style="color: #4A90D9; text-decoration: none;">&larr; Retour aux permissions</a>
    </div>

    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 2rem; margin-bottom: 1.5rem;">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; color: #1e293b;">{{ $permission->name }}</h2>
        <p style="color: #64748b; margin: 0 0 1.5rem 0;">{{ $stats['description'] ?? '' }}</p>

        <div style="display: flex; gap: 2rem; margin-bottom: 1.5rem;">
            <div>
                <span style="font-size: 1.5rem; font-weight: 700; color: #1e293b;">{{ $stats['roles_count'] ?? 0 }}</span>
                <span style="display: block; font-size: 0.8rem; color: #64748b;">Roles</span>
            </div>
            <div>
                <span style="font-size: 1.5rem; font-weight: 700; color: #1e293b;">{{ $stats['users_count'] ?? 0 }}</span>
                <span style="display: block; font-size: 0.8rem; color: #64748b;">Utilisateurs</span>
            </div>
        </div>

        <h3 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0 0 1rem 0;">Roles avec cette permission</h3>
        @if($permission->roles->count() > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @foreach($permission->roles as $role)
                    <span style="display: inline-block; padding: 0.35rem 0.75rem; background: #F0FDF4; color: #22C55E; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                        {{ $role->name }}
                    </span>
                @endforeach
            </div>
        @else
            <p style="color: #94a3b8;">Aucun role n'a cette permission.</p>
        @endif
    </div>

    @if(isset($users) && $users->count() > 0)
    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 2rem;">
        <h3 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0 0 1rem 0;">Utilisateurs</h3>
        @foreach($users as $user)
            <div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between;">
                <span style="font-weight: 500; color: #1e293b;">{{ $user->name }}</span>
                <span style="color: #64748b; font-size: 0.85rem;">{{ $user->email }}</span>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
