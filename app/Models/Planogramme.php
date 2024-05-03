<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planogramme extends Model
{
    use HasFactory;
    protected $table = 'planogramme';
    protected $primaryKey = 'PlanoID';
    public $timestamps = false;

    protected $fillable = [
        'Type_plano', 'Conformite_plano'
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'PlanoID');
    }

    public function histoPlano()
    {
        return $this->hasMany(HistoPlano::class, 'PlanoID');
    }
}
