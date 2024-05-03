<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficier extends Model
{
    use HasFactory;
    protected $table = 'beneficier';
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'pointeID', 'ProduitID', 'PromotionID'
    ];
    public function pointDeVente()
    {
        return $this->belongsTo(PointDeVente::class, 'pointeID');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'ProduitID');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'PromotionID');
    }
}
