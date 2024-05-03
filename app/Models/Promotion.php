<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'Promotion';
    protected $primaryKey = 'PromotionID';
    public $timestamps = false;

    protected $fillable = [
        'statut', 'nbre_stand_promotionnel', 'date_debut_promo', 'date_fin_promo'
    ];

    public function visiteData()
    {
        return $this->hasMany(VisiteData::class, 'PromotionID');
    }

    public function beneficier()
    {
        return $this->hasMany(Beneficier::class, 'PromotionID');
    }

    public function histoPromo()
    {
        return $this->hasMany(HistoPromo::class, 'PromotionID');
    }

}
