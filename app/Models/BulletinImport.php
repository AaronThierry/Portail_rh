<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulletinImport extends Model
{
    protected $table = 'bulletin_imports';

    protected $fillable = [
        'entreprise_id',
        'uploaded_by',
        'fichier_zip',
        'periode',
        'total',
        'succes',
        'doublons',
        'erreurs_count',
        'erreurs',
        'bulletins_crees',
        'statut',
    ];

    protected $casts = [
        'erreurs'         => 'array',
        'bulletins_crees' => 'array',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_cours' => 'En cours',
            'termine'  => 'Terminé',
            'partiel'  => 'Partiel',
            'echec'    => 'Échec',
            default    => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match ($this->statut) {
            'termine'  => 'success',
            'partiel'  => 'warning',
            'echec'    => 'danger',
            default    => 'secondary',
        };
    }
}
