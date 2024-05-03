<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoPtvente extends Model
{
    use HasFactory;
    protected $table = 'Histo_ptvente';
    public $timestamps = false;

    public function pointDeVente()
    {
        return $this->belongsTo(PointDeVente::class, 'pointeID');
    }

    public function historique()
    {
        return $this->belongsTo(Historique::class, 'HistoriqueID');
    }
}
