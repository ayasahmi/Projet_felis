<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitInfoPointVente extends Model
{
    use HasFactory;
    protected $table = 'ProduitInfoPointVente';
    public $timestamps = false;

    protected $fillable = [
        'pointeID', 'ProduitID', 'facing', 'position_etagere', 'espace_etagere',
        'espace_produit', 'shelf_sharing', 'qte_stock_reserv', 'qte_stock_picking',
        'qte_stock_min', 'qte_stock_max', 'date_entree_stock'
    ];
    public function pointDeVente()
    {
        return $this->belongsTo(PointDeVente::class, 'pointeID');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'ProduitID');
    }
}
