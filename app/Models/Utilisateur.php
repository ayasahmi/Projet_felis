<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;
    protected $table = 'Utilisateur';
    protected $primaryKey = 'UtilisateurID';
    public $timestamps = false;

    protected $fillable = [
        'nom', 'prenom', 'mail', 'motdepasse', 'phone', 'role', 'photo_user',
        'Nbr_users', 'type_souscription', 'nomentreprise', 'adresse', 'ville',
        'date_creation', 'statut_activation','date_expiration'
    ];
    public function historiques()
    {
        return $this->hasMany(Historique::class, 'UtilisateurID');
    }

    public function visites()
    {
        return $this->hasMany(Visite::class, 'UtilisateurID');
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'UtilisateurID');
    }
    public function visiteData()
    {
        return $this->hasManyThrough(VisiteData::class, Visite::class, 'UtilisateurID', 'visiteID');
    }
}
