<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'scope',
        'description',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Récupérer une valeur de paramètre
     */
    public static function get($key, $default = null, $scope = 'global')
    {
        $setting = self::where('key', $key)
            ->where('scope', $scope)
            ->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Définir une valeur de paramètre
     */
    public static function set($key, $value, $scope = 'global', $description = null, $type = 'string')
    {
        return self::updateOrCreate(
            ['key' => $key, 'scope' => $scope],
            [
                'value' => $value,
                'description' => $description,
                'type' => $type,
            ]
        );
    }

    /**
     * Supprimer un paramètre
     */
    public static function remove($key, $scope = 'global')
    {
        return self::where('key', $key)
            ->where('scope', $scope)
            ->delete();
    }

    /**
     * Récupérer tous les paramètres d'un scope
     */
    public static function getAllByScope($scope = 'global')
    {
        return self::where('scope', $scope)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Vérifier si un paramètre existe
     */
    public static function has($key, $scope = 'global')
    {
        return self::where('key', $key)
            ->where('scope', $scope)
            ->exists();
    }
}
