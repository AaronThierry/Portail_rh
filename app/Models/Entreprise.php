<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'sigle',
        'email',
        'telephone',
        'adresse',
        'quartier',
        'ville',
        'pays',
        'code_postal',
        'site_web',
        'logo',
        'description',
        'secteur_activite',
        'nombre_employes',
        'numero_registre',
        'numero_fiscal',
        'numero_cnss',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'nombre_employes' => 'integer',
    ];

    /**
     * Relation avec les utilisateurs
     */
    public function utilisateurs()
    {
        return $this->hasMany(User::class, 'entreprise_id');
    }

    /**
     * Relation avec les départements
     */
    public function departements()
    {
        return $this->hasMany(Departement::class, 'entreprise_id');
    }

    /**
     * Relation avec les services
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'entreprise_id');
    }
}
