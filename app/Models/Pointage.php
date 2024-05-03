<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;
    protected $table = 'pointage';
    protected $primaryKey = 'PointageID';
    public $timestamps = false;

    protected $fillable = [
        'localisation_long', 'localisation_lat', 'tolerance', 'presence',
        'date_arrivee', 'date_depart', 'UtilisateurID'
    ];
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'UtilisateurID');
    }

    public function histoPointage()
    {
        return $this->hasMany(HistoPointage::class, 'PointageID');
    }
}
