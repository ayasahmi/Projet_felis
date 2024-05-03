<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiteData extends Model
{
    use HasFactory;
    protected $table = 'visite_data';
    protected $primaryKey = 'ImageID';
    public $timestamps = false;

    protected $fillable = [
        'url_image', 'type_data', 'date_image', 'facing', 'stock', 'position_rack',
        'UtilisateurID', 'pointeID', 'PromotionID', 'ProduitID'
    ];

    // Relations
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'UtilisateurID');
    }

    public function pointDeVente()
    {
        return $this->belongsTo(PointDeVente::class, 'pointeID');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'PromotionID');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'ProduitID');
    }

    public function histoVisiteData()
    {
        return $this->hasMany(HistoVisiteData::class, 'ImageID');
    }
}
