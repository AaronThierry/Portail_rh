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
        'motif_desactivation',
        'date_motif_desactivation',
        'desactive_le',
        'desactive_par_id',
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
        'desactive_le' => 'datetime',
        'date_motif_desactivation' => 'date',
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

    /**
     * Jetons d'appareils enregistrés pour les notifications push (app mobile)
     */
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    /**
     * Abonnements Web Push (navigateurs / PWA installée — notamment iPhone Safari)
     */
    public function webPushSubscriptions()
    {
        return $this->hasMany(WebPushSubscription::class);
    }

    /**
     * Admin ayant désactivé ce compte (null si toujours actif ou jamais désactivé)
     */
    public function desactivePar()
    {
        return $this->belongsTo(User::class, 'desactive_par_id');
    }

    /**
     * Libellé lisible du motif de désactivation
     */
    public function getMotifDesactivationLabelAttribute(): ?string
    {
        return match ($this->motif_desactivation) {
            'demission' => 'Démission',
            'licenciement' => 'Licenciement',
            'fin_contrat' => 'Fin de contrat',
            'autre' => 'Autre',
            default => null,
        };
    }
}
