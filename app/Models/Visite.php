<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;
    protected $table = 'visite';
    protected $primaryKey = 'VisiteID';
    public $timestamps = false;

    protected $fillable = [
        'statut', 'heure_debut', 'heure_fin', 'date_planifiee', 'num_semaines', 'nom_journée', 'annee',
        'UtilisateurID', 'pointeID'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'UtilisateurID');
    }

    public function pointDeVente()
    {
        return $this->belongsTo(PointDeVente::class, 'pointeID');
    }

    public function visiteData()
    {
        return $this->hasMany(VisiteData::class, 'VisiteID');
    }

    public function histoVisite()
    {
        return $this->hasMany(HistoVisite::class, 'VisiteID');
    }
}
