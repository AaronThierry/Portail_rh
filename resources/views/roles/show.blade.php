@extends('layouts.app')

@section('title', 'Role - ' . $role->name)
@section('page-title', 'Details du Role')

@section('content')
<div style="padding: 1.5rem;">
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('admin.roles.index') }}" style="color: #4A90D9; text-decoration: none;">&larr; Retour aux roles</a>
    </div>

    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 2rem; margin-bottom: 1.5rem;">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; color: #1e293b;">{{ $role->name }}</h2>
        <p style="color: #64748b; margin: 0 0 1.5rem 0;">{{ $role->users_count ?? 0 }} utilisateur(s) avec ce role</p>

        <h3 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0 0 1rem 0;">Permissions ({{ $role->permissions->count() }})</h3>

        @if($role->permissions->count() > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @foreach($role->permissions as $permission)
                    <span style="display: inline-block; padding: 0.35rem 0.75rem; background: #E8F4FD; color: #4A90D9; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                        {{ $permission->name }}
                    </span>
                @endforeach
            </div>
        @else
            <p style="color: #94a3b8;">Aucune permission attribuee.</p>
        @endif
    </div>

    @if(isset($role->users) && $role->users->count() > 0)
    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 2rem;">
        <h3 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0 0 1rem 0;">Utilisateurs</h3>
        @foreach($role->users as $user)
            <div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between;">
                <span style="font-weight: 500; color: #1e293b;">{{ $user->name }}</span>
                <span style="color: #64748b; font-size: 0.85rem;">{{ $user->email }}</span>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
