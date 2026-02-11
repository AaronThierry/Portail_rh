<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Personnel;

class User extends Authenticatable
{
    /**
     * Traits utilisés par le modèle User
     * - HasApiTokens: Gestion des tokens API (Sanctum)
     * - HasFactory: Permet l'utilisation de factories pour les tests
     * - Notifiable: Permet l'envoi de notifications
     * - HasRoles: Trait de Spatie Permission pour la gestion des rôles et permissions
     */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entreprise_id',
        'personnel_id',
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'role',
        'department',
        'status',
        'password_reset_code',
        'password_reset_expires_at',
        'force_password_change',
        'google2fa_enabled',
        'google2fa_secret',
        'google2fa_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'force_password_change' => 'boolean',
        'google2fa_enabled' => 'boolean',
        'google2fa_verified_at' => 'datetime',
    ];

    /**
     * Relation avec l'entreprise
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Relation avec le personnel
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }
}
