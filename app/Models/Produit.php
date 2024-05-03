<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $table = 'produit';
    protected $primaryKey = 'ProduitID';
    public $timestamps = false;

    protected $fillable = [
        'designation', 'prix_unitaire', 'description', 'prix_renseigne',
        'categorie', 'famille', 'sous_famille', 'sous_sous_famille', 'date_validite'
    ];
    public function planogramme()
    {
        return $this->belongsTo(Planogramme::class, 'PlanoID');
    }

    public function visiteData()
    {
        return $this->hasMany(VisiteData::class, 'ProduitID');
    }

    public function beneficier()
    {
        return $this->hasMany(Beneficier::class, 'ProduitID');
    }

    public function produitInfoPointVente()
    {
        return $this->hasMany(ProduitInfoPointVente::class, 'ProduitID');
    }
    public function histoProduit()
    {
        return $this->hasMany(HistoProduit::class, 'ProduitID');
    }
}
