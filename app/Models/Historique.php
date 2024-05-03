<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;
    protected $table = 'Historique';
    protected $primaryKey = 'HistoriqueID';
    public $timestamps = false;

    protected $fillable = [
        'champ_modifie', 'type_modification', 'date_modif', 'UtilisateurID'
    ];
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'UtilisateurID');
    }
}
