<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoProduit extends Model
{
    use HasFactory;
    protected $table = 'Histo_produit';
    public $timestamps = false;

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'ProduitID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
