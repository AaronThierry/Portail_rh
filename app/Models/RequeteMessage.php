<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequeteMessage extends Model
{
    protected $fillable = ['requete_id', 'user_id', 'role', 'content'];

    public function requete()
    {
        return $this->belongsTo(Requete::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isFromAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFromChef(): bool
    {
        return $this->role === 'chef';
    }
}
