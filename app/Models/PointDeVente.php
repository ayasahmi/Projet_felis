<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointDeVente extends Model
{
    use HasFactory;
    protected $table = 'point_de_vente';
    protected $primaryKey = 'pointeID';
    public $timestamps = false;

    protected $fillable = [
        'Nom', 'ville', 'Adresse', 'localisation_long', 'localisation_lat',
        'NomEnseigne', 'telephone', 'email', 'coche_par_admin'
    ];

    public function visites()
    {
        return $this->hasMany(Visite::class, 'pointeID');
    }

    public function visiteData()
    {
        return $this->hasMany(VisiteData::class, 'pointeID');
    }

    public function beneficier()
    {
        return $this->hasMany(Beneficier::class, 'pointeID');
    }

    public function histoPtvente()
    {
        return $this->hasMany(HistoPtvente::class, 'pointeID');
    }

    public function produitInfoPointVente()
    {
        return $this->hasMany(ProduitInfoPointVente::class, 'pointeID');
    }
}

